$(document).ready(function () {
    var page = 1;
    var loading = false;

    function loadMoreData() {
        if (loading) {
            return;
        }
        loading = true;
        var url = uri + '/fetch/' + page;
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                var magangData = response.magang;

                magangData.forEach(function (item) {
                    var image = item.image === '' ? newURL + 'storage/image/upi.png' : item.image;
                    var applyButton = '';
                    if(response.request)
                    {
                        switch (item.lecture) {
                            case '0':
                                applyButton = `
                                    <button class="btn btn-danger w-100 disabled">
                                        Kuota Penuh
                                    </button>
                                `;
                                break;
                            default:
                                applyButton = `
                                    <button type="submit" class="btn btn-primary w-100 apply-btn" data-id="${item.id}">
                                        APPLY
                                    </button>
                                `;
                                break;
                        }
                    }

                    var cardHtml = `
                    <div class="card mx-3 text-break mb-4" style="max-width: 300px; min-height: 400px; width: 100%;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="text-center mb-3">
                                    <img class="card-img-top w-100 img-fluid mb-3" src="${image}" alt="alt-img" style="height: 200px; object-fit: cover;" />
                                    <h4 class="card-title mb-0">${item.title}</h4>
                                    <hr>
                                    <p class="card-text">${item.author}</p>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <div class="mb-2">
                                    <p class="mb-1">Posisi yang tersedia : ${item.lecture} orang</p>
                                    <button class="btn btn-primary w-100 description-btn" data-bs-toggle="modal" data-bs-target="#descriptionModal${item.id}">
                                        Deskripsi
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="descriptionModal${item.id}" tabindex="-1" aria-labelledby="descriptionModalLabel${item.id}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="descriptionModalLabel${item.id}">Deskripsi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>${item.description}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                ${applyButton}
                            </div>
                        </div>
                    </div>
                `;
                
                
                
                
                

                    $('#magangContainer').append(cardHtml);
                });

                page++;
                loading = false;
            },
            error: function () {
                loading = false;
                // console.error('Failed to load data.');
            }
        });
    }

    $('#magangContainer').on('click', '.apply-btn', function (event) {
        event.preventDefault(); 

        var itemId = $(this).data('id');
        showSwal(itemId);
    });

    function performSearch() {
        var searchKeyword = $('#search').val();
    
        $.ajax({
            url: uri + '/search',
            method: 'POST',
            data: {
                search: searchKeyword
            },
            dataType: 'json',
            success: function (response) {
                $('#magangContainer').empty();
    
                var magangData = response;
    
                magangData.forEach(function (item) {
                    var image = item.image === '' ? newURL + 'storage/image/upi.png' : item.image;
                    var applyButton = '';
    
                    if (item.request) { // Perubahan disini, menggunakan item.request
                        switch (item.lecture) {
                            case '0':
                                applyButton = `
                                    <button class="btn btn-danger w-100 disabled">
                                        Kuota Penuh
                                    </button>
                                `;
                                break;
                            default:
                                applyButton = `
                                    <button type="submit" class="btn btn-primary w-100 apply-btn" data-id="${item.id}">
                                        APPLY
                                    </button>
                                `;
                                break;
                        }
                    }
    
                    var cardHtml = `
                        <div class="card mx-3 text-break mb-4" style="max-width: 300px; min-height: 400px; width: 100%;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <div class="text-center mb-3">
                                        <img class="card-img-top w-100 img-fluid mb-3" src="${image}" alt="alt-img" style="height: 200px; object-fit: cover;" />
                                        <h4 class="card-title mb-0">${item.title}</h4>
                                        <hr>
                                        <p class="font-weight-bold">Alamat</p>
                                        <p class="card-text">${item.author}</p>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <div class="mb-2">
                                        <p class="mb-1">Posisi yang tersedia : ${item.lecture} orang</p>
                                        <button class="btn btn-primary w-100 description-btn" data-bs-toggle="modal" data-bs-target="#descriptionModal${item.id}">
                                            Deskripsi
                                        </button>
                                        <div class="modal fade" id="descriptionModal${item.id}" tabindex="-1" aria-labelledby="descriptionModalLabel${item.id}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="descriptionModalLabel${item.id}">Deskripsi</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>${item.description}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ${applyButton}
                                </div>
                            </div>
                        </div>
                    `;
    
                    $('#magangContainer').append(cardHtml);
                });
            },
            error: function () {
                // console.error('Failed to load data.');
            }
        });
    }
    

    // Event untuk tombol "Cari"
    $('#btn-search').on('click', function () {
        performSearch(); // Panggil fungsi pencarian saat tombol "Cari" ditekan
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            loadMoreData();
        }
    });

    // Swal function
    function showSwal(ids) {
        Swal.fire({
            title: 'Anda Yakin ?',
            text: 'Setelah Pemilihan Anda Tidak Dapat Mengulangi, Atau Hubungi Admin',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: uri + '/insert',
                    method: 'POST',
                    data: {
                        id: ids
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.includes('Berhasil')) {
                            showToast(response, 'bg-success');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            showToast(response, 'bg-danger');
                        }
                    },
                    error: function (error) {
                        showToast('Error! Unable to save data.', 'bg-danger');
                    }
                });
            }
        });
    }
    loadMoreData();
});
