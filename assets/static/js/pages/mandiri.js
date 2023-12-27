$(document).ready(function () {
    // checkbox
    let checked = $("#checkall").change(function() {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    })
        // Fungsi untuk mendapatkan data user berdasarkan username
        function getUsersByUsername(username) {
            $.ajax({
                url: uri + '/user',
                type: 'GET',
                data: { username: username },
                dataType: 'json',
                success: function(data) {
                    populateUserDropdown(data); // Memanggil fungsi untuk menambahkan hasil ke dropdown
                },
                error: function(error) {
                    console.error('Error fetching user data:', error);
                }
            });
        }
    
        // Fungsi untuk menambahkan hasil pencarian ke dropdown
        function populateUserDropdown(users) {
            $('#user').empty(); // Kosongkan dropdown sebelumnya
            if (users.length > 0) {
                users.forEach(function(user) {
                    $('#user').append($('<option>', {
                        value: user.id,
                        text: user.username
                    }));
                });
            } else {
                // Tambahkan opsi default jika tidak ada hasil pencarian
                $('#user').append($('<option>', {
                    text: 'Tidak ada hasil',
                    selected: true,
                    disabled: true
                }));
            }
        }
    
        // Event listener untuk input pencarian
        $('#searchUsername').on('input', function() {
            var username = $(this).val();
            getUsersByUsername(username);
        });


    // fetch data
    function fetchData() {
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const table = $('#table1').DataTable();
                table.clear().draw();
    
                data.forEach(item => {
                    const user = item.user;
                    const mandiri = item.mandiri;
                    const rowData = [
                        `<input type="checkbox" name="check[]" value="${item.id}" class="form-check-input form-check-success">`,
                        user.username,
                        mandiri.mitra,
                        mandiri.pic,
                        mandiri.job,
                        mandiri.number_pic,
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
                    ];
    
                    table.row.add(rowData).draw();
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
    $('#formSubmit').prop('id', 'formSubmit'); // Ganti properti 'id' ke 'formSubmit'
    $('#formModal')[0].reset();
        $('#user').empty();
        $('#user').append($('<option>', {
            value: '',
            text: 'Pilih user',
            selected: true
        }));
});

$(document).on('click', '#formSubmit', function(e) {
    e.preventDefault();
    var formData = new FormData($('#formModal')[0]);
    $.ajax({
        type: 'POST',
        url: uri + '/insert',
        data: formData,
        processData: false,  // Tambahkan ini untuk FormData
        contentType: false,  // Tambahkan ini untuk FormData
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
                $('#formModal input[name="mitra"]').val(response.mandiri.mitra);
                $('#formModal input[name="job"]').val(response.mandiri.job);
                $('#formModal input[name="pic"]').val(response.mandiri.pic);
                $('#formModal input[name="number_pic"]').val(response.mandiri.number_pic);
                const ownerSelect = $('#user');
                ownerSelect.empty();
                ownerSelect.append($('<option></option>').attr('value', response.user.id).text(response.user.username)); 
                ownerSelect.val(response.user.id); // Set nilai opsi dengan ID pengguna
                
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
    const formData = new FormData($('#formModal')[0]);
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