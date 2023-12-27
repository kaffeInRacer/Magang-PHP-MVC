$(document).ready(function () {
    $("#checkall").change(function() {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    });
    $('#searchUsername').on('input', function() {
        var username = $(this).val();
        var userEndpoint = uri + '/user?username=' + username;
        $.ajax({
            url: userEndpoint,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                populateDropdown($('#user'), data);
            },
            error: function(error) {
                console.error('Error fetching user data:', error);
            }
        });
    });

    $('#searchMitra').on('input', function() {
        var selectedType = $('#type').val();
        var title = $(this).val();
        var endpoint = (selectedType === 'partnership') ? uri + '/partnership?title=' + title : uri + '/penelitian?title=' + title;
        $.ajax({
            url: endpoint,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                populateDropdown($('#mitra'), data);
            },
            error: function(error) {
                console.error('Error fetching mitra data:', error);
            }
        });
    });

    $('#type').change(function() {
        $('#mitra').empty(); 
        $('#mitra').append($('<option>', {
            text: 'Pilih mitra:',
            selected: true
        }));
    });

    function populateDropdown(dropdown, data) {
        dropdown.empty();

        if (data && data.length > 0) {
            data.forEach(function(item) {
                dropdown.append($('<option>', {
                    value: item.id,
                    text: item.title || item.username
                }));
            });
        } else {
            dropdown.append($('<option>', {
                text: 'Tidak ada hasil',
                selected: true,
                disabled: true
            }));
        }
    }


    $(document).on('click', '#_insertData', function(e) {
        e.preventDefault();
        $('#formUpdate').prop('id', 'formSubmit'); // Change ID for submit button during insert
        $('#formModal')[0].reset();
        $('#mitra').empty(); 
        $('#mitra').append($('<option>', {
            text: 'Pilih mitra:',
            selected: true
        }));
        $('#user').empty(); 
        $('#user').append($('<option>', {
            text: 'Pilih user:',
            selected: true
        }));
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

    //fetch data
    function fetchData() {
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const table = $('#table1').DataTable();
                table.clear().draw();
    
                data.forEach(item => {
                    const rowData = [
                        `<input type="checkbox" name="check[]" value="${item.following_internship_id}" class="form-check-input form-check-success">`,
                        item.username,
                        item.title,
                        item.type,
                        item.created_at,
                        `<div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-pencil-square"></i> Action
                            </button>
                            <div class="dropdown-menu gap-2" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${item.following_internship_id}" id="_update"><i class="bi bi-pencil-fill"></i> Update</button>
                                <button class="dropdown-item" id="_delete" data-id="${item.following_internship_id}"><i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>`
                    ];
    
                    table.row.add(rowData).draw();
                });
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }
    
    // update
    $(document).on('click', '#_update', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        $.ajax({
            url: uri + '/show?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('#user').empty().append(`<option selected value="${response.user_id}">${response.username}</option>`);
                    $('#mitra').empty().append(`<option selected value="${response.magang_id}">${response.title}</option>`);

                    $('#type').val(response.type);
                    $('#formSubmit').prop('id', 'formUpdate').data('id', id);
                } else {
                    showToast('Error! Data not found.', 'bg-danger');
                }
            },
            error: function (error) {
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
                    showToast('Error! Unable to update data.', 'bg-danger');
                }
                $('#formModal')[0].reset();
                fetchData();
            },
            error: function(error) {
                showToast('Error! Unable to update data.', 'bg-danger');
            }
        });
    });

    // delete by cehckbox
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
     $(document).on('click', '#_delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        showSwal(id);
    });

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
    fetchData()
});
