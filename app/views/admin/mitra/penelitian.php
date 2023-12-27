<div id="app">
    <div id="sidebar">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <a href="index.html"><img src="<?= BASE_URL ?>assets/compiled/svg/logo.svg" alt="Logo" srcset=""></a>
                    </div>
                    <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                <g transform="translate(-210 -1)">
                                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                            <label class="form-check-label"></label>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                            </path>
                        </svg>
                    </div>
                    <div class="sidebar-toggler  x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Menu</li>

                    <li class="sidebar-item ">
                        <a href="<?= BASE_URL ?>admin/dashboard" class='sidebar-link'>
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item active has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-building-fill"></i>
                            <span>Mitra</span>
                        </a>
                        <ul class="submenu submenu-open">
                            <li class="submenu-item  ">
                                <a href="<?= BASE_URL ?>admin/partnership" class="submenu-link"><i class="bi bi-list-task"></i> Mitra Partnership</a>
                            </li>
                            <li class="submenu-item active ">
                                <a href="<?= BASE_URL ?>admin/penelitian" class="submenu-link"><i class="bi bi-list-task"></i> Mitra Penelitian</a>
                            </li>
                            <li class="submenu-item  ">
                                <a href="<?= BASE_URL ?>admin/mandiri" class="submenu-link"><i class="bi bi-card-list"></i> Mitra Mandiri</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item has-sub">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-mortarboard"></i>
                            <span>Mahasiswa</span>
                        </a>
                        <ul class="submenu submenu-closed">
                            <li class="submenu-item">
                                <a href="<?= BASE_URL ?>admin/mahasiswa" class="submenu-link"><i class="bi bi-list-task"></i> Tambah Mahasiswa</a>
                            </li>
                            <li class="submenu-item">
                                <a href="<?= BASE_URL ?>admin/internship" class="submenu-link"><i class="bi bi-list-task"></i> Mahasiswa Internship</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= BASE_URL ?>admin/add_admin" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Admin</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div id="main" class='layout-navbar navbar-fixed'>
        <header>
            <nav class="navbar navbar-expand navbar-light navbar-top">
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block">
                        <i class="bi bi-justify fs-3"></i>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <!-- <ul class="navbar-nav ms-auto mb-lg-0">

                            </ul> -->
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600"><?= $_SESSION['user']['role'] ?></h6>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="<?= BASE_URL ?>assets/compiled/jpg/1.jpg">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>dashboard"><i class="icon-mid bi bi-wallet me-2"></i>
                                        Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>action_logout"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="formModal" enctype="multipart/form-data" novalidate>
                            <div class="mb-3">

                                <label for="tittle" class="form-label">Title:</label>
                                <input type="text" name="tittle" class="form-control mb-3" />

                                <label for="address" class="form-label">Author:</label>
                                <input type="text" name="author" class="form-control mb-3" />

                                <label for="address" class="form-label">Owner:</label>
                                <select name="owner" class="form-select mb-3" id="owner">
                                    <option selected>Pilih Pemilik Penelitian</option>
                                </select>

                                <label for="lecture" class="form-label">Lecture:</label>
                                <input type="number" name="lecture" class="form-control mb-3" />

                                <!-- CKEeditor -->
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" id="description"></textarea>

                                <label for="image" class="form-label">Image:</label>
                                <input type="file" name="image" class="form-control mb-3" />
                                <div class="text-center">
                                    <img id="display" src="" alt="">
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="formSubmit">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="main-content">
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Mitra Penelitian</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="<?= BASE_URL ?>admin/mitra">Mitra</a></li>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Content -->
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-4">
                                <button type="button" id="_insertData" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Create Data
                                </button>

                                <button id="selectedDelete" class="btn btn-danger" href="#" role="button">Delete Selected</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 50px;"><input type="checkbox" id="checkall" class="form-check-input form-check-success"> All</th>
                                            <!-- <th scope="col">no</th> -->
                                            <th scope="col">Title</th>
                                            <th scope="col">Lecture</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">created_at</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>