$(document).ready(function () {
    // checkbox
    let checked = $("#checkall").change(function() {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    })
    //ckeditor
    let editor;
    ClassicEditor.create(document.querySelector("#description"), {
        toolbar: {
            items: [
                'bold',
                'italic',
                'bulletedList',
                'numberedList'
            ],
        },
        language: 'en',
        image: {
            toolbar: [
                'imageTextAlternative'
            ]
        },
    })
    .then(newEditor => {
        editor = newEditor;
    })
    .catch((error) => {
        console.error(error);
    });



    // fetch data
    function fetchData() {
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Owner fetch
                const users = data.user;
                const ownerSelect = $('#owner');
                ownerSelect.empty();
                
                users.forEach(user => {
                    const option = $('<option></option>').attr('value', user.id).text(user.username);
                    ownerSelect.append(option);
                });
                // Table show
                const table = $('#table1').DataTable();
                table.clear().draw();
                const setTableColor = () => {
                    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                        dt.classList.add('pagination-primary');
                    });
                };
                setTableColor();
                table.on('draw', setTableColor);
                data.mitra.forEach(item => {
                    table.row.add([
                        `<input type="checkbox" name="check[]" value="${item.id}" class="form-check-input form-check-success">`,
                        item.title,
                        item.lecture,
                        item.author,
                        item.created_at,
                        `<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-pencil-square"></i> Action
                            </button>
                            <div class="dropdown-menu gap-2" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${item.id}" id="_update"><i class="bi bi-pencil-fill"></i> Update</button>
                                <button class="dropdown-item" id="_delete" data-id="${item.id}"><i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>`
                    ]).draw();
                });
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }


    // insert Data
    $(document).on('click', '#_insertData', function (e) {
        e.preventDefault();
        $('#formUpdate').prop('id', 'formSubmit'); // Changed from attr() to prop()
        $('#formModal')[0].reset();
        editor.setData(''); // Reset CKEditor
        $('#display').attr('src', '').hide();
        });
    
    $(document).on('click', '#formSubmit', function(e) {
        e.preventDefault();    
        const editorData = editor.getData();    
        var formData = new FormData($('#formModal')[0]);
        formData.append('description', editorData);
        $.ajax({
            type: 'POST',
            url: uri + '/insert',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#exampleModal').modal('hide');
                if (response.includes('Berhasil')) {
                    showToast(response, 'bg-success');
                } else {
                    showToast(response, 'bg-danger');
                }
                $('#formModal')[0].reset();
                fetchData();
            },
            error: function(error) {
                showToast('Error! Unable to save data.', 'bg-danger');
            }
        });
    });

    // Delete data
    $(document).on('click', '#_delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        showSwal(id);
    });
        // Delete By CheckBox
        $(document).on('click', '#selectedDelete', function(e) {
            e.preventDefault();
            var selectedItems = $('input[name="check[]"]:checked').map(function() {
                return this.value;
            }).get();
    
            if (selectedItems.length === 0) {
                showToast('No items selected for deletion!', 'bg-danger');
                return;
            }
    
            showSwal(selectedItems);
        });

// get data by ID
$(document).on('click', '#_update', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    $.ajax({
        url: uri + '/show?id=' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response && response.id) {
                // Isi formulir dengan data yang diterima
                $('#formModal input[name="tittle"]').val(response.title);
                $('#formModal input[name="lecture"]').val(response.lecture);
                $('#formModal input[name="author"]').val(response.author);
                editor.setData(response.description);
                if (response.image !== "") {
                    $('#display')
                        .attr('src', `${BASE_URL}/${response.image}`)
                        .attr('class', 'img-fluid img-thumbnail')
                        .show();
                } else {
                    $('#display').empty();
                }
                // Match owner select
                const ownerSelect = $('#owner');
                ownerSelect.val(response.user_id || response.username);
                // Ubah tombol menjadi tombol Update
                $('#formSubmit').prop('id', 'formUpdate');
                $('#formUpdate').data('id', id);
            } else {
                showToast('Error! Unable to fetch data.', 'bg-danger');
            }
        },
        error: function (error) {
            showToast('Error! Unable to fetch data.', 'bg-danger');
        }
    });
});


// update data
$(document).on('click', '#formUpdate', function (e) {
    e.preventDefault();
    const id = $(this).data('id');
    const editorData = editor.getData();
    const formData = new FormData($('#formModal')[0]);
    formData.append('description', editorData);
    formData.append('id', id);
    $.ajax({
        type: 'POST',
        url: uri + '/update',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#exampleModal').modal('hide');
            if (response.includes('Berhasil')) {
                    showToast(response, 'bg-success');
                } else {
                    showToast(response, 'bg-danger');
                }
            $('#formModal')[0].reset();
            fetchData(); // Pastikan fetchData telah didefinisikan sebelumnya
        },
        error: function (error) {
            showToast('Error! Unable to update data.', 'bg-danger');
        }
    });
});



    // Preview image
    $('input[name="image"]').change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#display')
                .attr('src', e.target.result)
                .attr('class', 'img-fluid')
                .show(); // Menampilkan gambar
                
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Swal function
    function showSwal(ids) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan penghapusan data dengan AJAX
                $.ajax({
                    type: 'POST',
                    url: uri + '/destroy',
                    data: { id: ids },
                    success: function (response) {
                        if (response.includes('Berhasil')) {
                            showToast(response, 'bg-success');
                            $('#checkall').prop('checked', false);
                        } else {
                            showToast('Error! Unable to delete selected items.', 'bg-danger');
                        }
                        fetchData();
                    },
                    error: function (xhr, status, error) {
                        showToast('Error! Unable to delete selected items.', 'bg-danger');
                    }
                });
            }
        });
    }
    fetchData();
});