$(document).ready(function() {
    // Fetch data
    function fetchData() {
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const table = $('#table1').DataTable();
                table.clear().draw();

                data.user.forEach(user => {
                    const rowData = [
                        `<input type="checkbox" name="check[]" value="${user.id}" class="form-check-input form-check-success">`,
                        user.username,
                        user.email,
                        user.telp,
                        user.gender === 'L' ? 'Pria' : 'Wanita',
                        `<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-pencil-square"></i> Action
                            </button>
                            <div class="dropdown-menu gap-2" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${user.id}" id="_update"><i class="bi bi-pencil-fill"></i> Update</button>
                                <button class="dropdown-item" id="_delete" data-id="${user.id}"><i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>`
                    ];

                    table.row.add(rowData).draw();
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Checkbox: Check all
    $("#checkall").change(function() {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    });

    // Insert data
    $(document).on('click', '#_insertData', function(e) {
        e.preventDefault();
        $('#formUpdate').prop('id', 'formSubmit'); // Change ID for submit button during insert
        $('#formModal')[0].reset();
        $('#display').attr('src', '').hide();
    });

    $(document).on('click', '#formSubmit', function(e) {
        e.preventDefault();
        const formData = new FormData($('#formModal')[0]);
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

    // Update data
    $(document).on('click', '#_update', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $.ajax({
            url: uri + '/show?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#username').val(response.username);
                    $('#email').val(response.email);
                    $('#telp').val(response.telp);
                    $('#gender').val(response.gender);
                    if (response.image !== "") {
                        $('#display')
                            .attr('src', `${BASE_URL}/${response.image}`)
                            .attr('class', 'img-fluid img-thumbnail')
                            .show();
                    } else {
                        $('#display').empty();
                    }
                    $('#formSubmit').prop('id', 'formUpdate');
                    $('#formUpdate').data('id', id);
                } else {
                    showToast('Error! Unable to fetch data.', 'bg-danger');
                }
                $('#formSubmit').prop('id', 'formUpdate');
                $('#formUpdate').data('id', id);
            },
            error: function(error) {
                showToast('Error! Unable to fetch data.', 'bg-danger');
            }
        });
    });

    $(document).on('click', '#formUpdate', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const formData = new FormData($('#formModal')[0]);
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
                    showToast(response, 'bg-danger');
                }
                $('#formModal')[0].reset();
                fetchData();
            },
            error: function(error) {
                showToast('Error! Unable to update data.', 'bg-danger');
            }
        });
    });

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
                        fetchData();
                    },
                    error: function(xhr, status, error) {
                        showToast('Error! Unable to delete selected items.', 'bg-danger');
                    }
                });
            }
        });
    }

    // Preview image
    $('input[name="image"]').change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#display')
                    .attr('src', e.target.result)
                    .attr('class', 'img-fluid')
                    .show();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Initially fetch data
    fetchData();
});
