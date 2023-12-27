$(document).ready(function() {
    // checkbox
    let checked = $("#checkall").change(function() {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    })
        
    // fetch type
    function fetchTypes() {
        fetch(uri + '/fetch')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const selectType = document.getElementById('type');
                selectType.innerHTML = '';
    
                // Assuming 'data.types' is the correct property in your response JSON
                data.types.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    selectType.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching types:', error);
            });
    }
    

    // fetch data
    function dataFetch() {
        var table = $('#table1').DataTable();
        const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                dt.classList.add('pagination-primary')
            })
        }
        setTableColor()
        table.on('draw', setTableColor)
        fetch(uri + '/fetch')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                table.clear().draw();

                data.mitras.forEach(item => {
                    const typeName = item.type[0].type_name;

                    table.row.add([
                        `<input type="checkbox" name="check[]" value="${item.id}" class="form-check-input form-check-success">`,
                        item.name,
                        item.lecture,
                        typeName,
                        item.mou_file !== "" ? `<a href="${BASE_URL}/${item.mou_file}" target="_blank" class="btn btn-primary">Open file</a>` : "", // Pengecekan file MOU
                        item.created_at,
                        `
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-pencil-square"></i> Action
                            </button>
                            <div class="dropdown-menu gap-2" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${item.id}" id="_update"><i class="bi bi-pencil-fill"></i> Update</button>
                                <button class="dropdown-item" id="_delete" data-id="${item.id}"><i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>
                        `
                    ]).draw();
                    
                });
            })
            .catch(error => {
                console.error('Error fetching mitras:', error);
            });
    }

    // insert data
    $(document).on('click', '#_insertData', function(e) {
        e.preventDefault();
        $('#formUpdate').prop('id', 'formSubmit'); // Changed from attr() to prop()
        $('#formModal')[0].reset();
        $('#mou')
            .attr('class', '')
            .attr('href', '');
        $('#display')
            .attr('class', '')
            .attr('src', '')
            .attr('alt', '');
    });
    $(document).on('click', '#formSubmit', function(e) {
        e.preventDefault();
        var formData = new FormData($('#formModal')[0]);

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
                    showToast('Error! Unable to Update data.', 'bg-danger');
                }
                $('#formModal')[0].reset();
                dataFetch();
            },
            error: function(error) {
                showToast('Error! Unable to Update data.', 'bg-danger');
            }
        });
    });
    
// Update data
$(document).on('click', '#formUpdate', function(e) {
    e.preventDefault();
    var formData = new FormData($('#formModal')[0]);
    var id = $(this).data('id');

    formData.append('id', id);

    $.ajax({
        type: 'POST',
        url: uri + '/update',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#exampleModal').modal('hide');
            if (response.includes('Berhasil')) {
                showToast(response, 'bg-success');
            } else {
                showToast('Error! Unable to Update data.', 'bg-danger');
            }
            $('#formModal')[0].reset();
            dataFetch();
        },
        error: function(error) {
            showToast('Error! Unable to Update data.', 'bg-danger');
        }
    });
});


// Image preview handling for the 'image' input
$('input[name="image"]').change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#display').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// Image preview handling for the 'mou' input
$('input[name="mou"]').change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#mou').text('Mou File').attr('href', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    }
});


    // get data
    $(document).on('click', '#_update', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        fetch(uri + '/fetch')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const selectType = document.getElementById('type');
                selectType.innerHTML = ''; 

                data.types.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = type.name;
                    selectType.appendChild(option);
                });

                return fetch(uri + '/show?id=' + id);
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(response => {
                if (response && response.mitras && response.mitras.length > 0) {
                    const mitra = response.mitras[0];
                    console.log(mitra.mou_file)
                    console.log(mitra.image)
                    $('#formModal')[0].reset();
                    $('#exampleModal').modal('show');
                    $('#formModal input[name="name"]').val(mitra.name);
                    $('#formModal input[name="lecture"]').val(mitra.lecture);
                    // Match type
                    const selectType = document.getElementById('type');
                    if (mitra.type && mitra.type.length > 0) {
                        const typeId = mitra.type[0].type_id;
                        selectType.value = typeId;
                    }

                    $('#formModal textarea[name="description"]').val(mitra.description);
                    $('#formSubmit').attr('id', 'formUpdate');
                    $('#formUpdate').data('id', id); // Set the 'id' data attribute for formUpdate button
                    if (mitra.image !== '') {
                        $('#display')
                            .attr('src', `${BASE_URL}/${mitra.image}`)
                            .attr('alt', 'Image Alt Text')
                            .attr('class', 'img-fluid img-thumbnail mb-3')
                            .css({ width: '40%', height: 'auto' });
                    } else {
                        $('#display').hide();
                    }

                    if (mitra.mou_file !== '') {
                        $('#mou')
                            .attr('href', `${BASE_URL}/${mitra.mou_file}`)
                            .text("Mou File")
                            .attr('class', 'btn btn-primary')
                            .attr('target', '_blank')
                            .show();
                    } else {
                        $('#mou').hide();
                    }
                    
                } else {
                    showToast('Error! Unable to fetch data.', 'bg-danger');
                }
            })
            .catch(error => {
                showToast('Error! Unable to fetch data.', 'bg-danger');
            });
    });

    // delete data
    $(document).on('click', '#_delete', function(e) {
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
    


    // Call functions to display data
    fetchTypes();
    dataFetch();
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
                    // User confirmed, proceed with deletion
                    $.ajax({
                        type: 'POST',
                        url: uri + '/destroy',
                        data: { id: ids },
                        success: function(response) {
                            if (response.includes('Berhasil')) {
                                showToast(response, 'bg-success');
                                $('#checkall').prop('checked', false);
                            } else {
                                showToast('Error! Unable to delete selected items.', 'bg-danger');
                            }
                            dataFetch();
                        },
                        error: function(xhr, status, error) {
                            showToast('Error! Unable to delete selected items.', 'bg-danger');
                        }
                    });
                }
            });
        }
});
