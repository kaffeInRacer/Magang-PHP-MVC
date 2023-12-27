$(document).ready(function () {
    // checkbox
    $("#checkall").change(function () {
        $('input[name="check[]"]').prop('checked', $(this).prop('checked'));
    });

    // Fetch Mitra
    function fetchMitra() {
        var table = $('#table1').DataTable();
        const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                dt.classList.add('pagination-primary')
            })
        }
        setTableColor()
        table.on('draw', setTableColor)
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const mitraList = data.mitra;
                const selectType = $('#type');
                selectType.empty();

                // Tambahkan opsi default "Pilih Magang"
                selectType.append('<option value="" selected>Pilih Magang</option>');

                // Tambahkan opsi untuk setiap entri mitra
                mitraList.forEach(mitra => {
                    const option = $('<option></option>');
                    option.attr('value', mitra.id);
                    option.text(mitra.name);
                    selectType.append(option);
                });
            },
            error: function (error) {
                console.error('Error fetching mitra:', error);
            }
        });
    }

    // Fetch Data
    function fetchData() {
        $.ajax({
            url: uri + '/fetch',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const userList = data.user;
                const table = $('#table1').DataTable();
                table.clear().draw();

                userList.forEach(user => {
                    const statusBadge = user.mitra_name !== "" ? '<span class="badge text-bg-success">aktif</span>' : '<span class="badge text-bg-danger">Tidak aktif</span>';
                    const gender = user.gender == 'L' ? 'pria' : 'wanita';
                    table.row.add([
                        `<input type="checkbox" name="check[]" value="${user.user_id}" class="form-check-input form-check-success">`,
                        user.username,
                        user.nim,
                        user.email,
                        gender,
                        statusBadge,
                        `
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-pencil-square"></i> Action
                            </button>
                            <div class="dropdown-menu gap-2" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${user.user_id}" id="_update"><i class="bi bi-pencil-fill"></i> Update</button>
                                <button class="dropdown-item" id="_delete" data-id="${user.user_id}"><i class="bi bi-trash-fill"></i> Delete</button>
                            </div>
                        </div>
                        `
                    ]).draw();
                });

                fetchMitra();
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Insert Data
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
    $('#formSubmit').on('click', function () {
        const formData = new FormData($('#formModal')[0]);
        $.ajax({
            type: 'POST',
            url: uri + '/insert', // Ganti URL_ANDA dengan URL endpoint untuk menyimpan data
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.includes('Berhasil')) {
                    showToast(response, 'bg-success');
                } else {
                    showToast(response, 'bg-danger');
                }
                fetchData(); // Ambil ulang data setelah penyimpanan berhasil
                $('#exampleModal').modal('hide'); // Sembunyikan modal setelah penyimpanan berhasil
            },
            error: function (error) {
                console.error('Error inserting data:', error);
            }
        });
    });

    // show data
    $(document).on('click', '#_update', function (e) {
        e.preventDefault();
        var userId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: uri + '/show?id=' + userId,
            dataType: 'json',
            success: function (userData) {
                $('#exampleModal').modal('show'); 
                $('#formModal').trigger('reset'); 
    
                // Mengisi formulir dengan data yang diambil
                $('input[name="name"]').val(userData.username);
                $('input[name="email"]').val(userData.email);
                $('input[name="nim"]').val(userData.nim);
                $('input[name="telp"]').val(userData.telp);
                
                var genderSelect = $('#gender');
                genderSelect.val(userData.gender);
                $('#type').val(userData.mitra_id);
    
                if (userData.image !== '') {
                    $('#display')
                        .attr('src', `${BASE_URL}/${userData.image}`)
                        .attr('alt', 'Image Alt Text')
                        .attr('class', 'img-fluid img-thumbnail mb-3')
                        .css({ width: '40%', height: 'auto' });
                } else {
                    $('#display').hide();
                }
    
                $('#formSubmit').attr('id', 'formUpdate');
                $('#formUpdate').data('id', id); // Set the 'id' data attribute for formUpdate button
        },
            error: function (error) {
                console.error('Error fetching user data:', error);
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
                    showToast(response, 'bg-danger');
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
    



    // Delete Data
    $(document).on('click', '#_delete', function (e) {
        e.preventDefault();
        var userId = $(this).data('id');
        showSwal(userId);
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

    // Fetch initial data
    fetchData();

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
