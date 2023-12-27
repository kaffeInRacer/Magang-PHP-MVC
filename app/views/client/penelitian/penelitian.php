    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto"> <!-- ml-auto untuk mengatur tombol login di sebelah kanan -->
        <li class="nav-item active">
          <a class="nav-link" href="home">Program</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kegiatan">Kegiatan Saya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mandiri">Magang Mandiri</a>
        </li>
        <li class="nav-item">
          <!-- Tombol Dropdown Profil -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-user"></i> Profil
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">Profil</a>
              <a class="dropdown-item" href="action_logout">Logout</a>
              <!-- <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Keluar</a> -->
            </div>
          </div>
        </li>
      </ul>
    </div>
    </nav>

    <!-- Features Section -->
    <div class="container mt-5">
      <!-- Judul Feature Section -->
      <h3>Posisi Magang Penelitian yang tersedia</h3>

      <div class="container mt-5">
        <div class="row">
          <div class="col-md-6">
            <!-- Search Bar di Sebelah Kiri -->
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari posisi atau perusahaan">
              <button class="btn btn-outline-secondary" type="button">Cari</button>
            </div>
          </div>
          <div class="col-md-6 text-end">
            <!-- Tombol di Sebelah Kanan -->
            <a href="partnership"><button class="btn btn-primary" type="button">Cari posisi lain di Magang Partnership -></button></a>
          </div>
        </div>
      </div>

      <!-- 4 Posisi dengan Keterangannya -->
      <div class="row mt-5 justify-content-center" id="magangContainer">
      </div>


      <!-- Footer -->
      <footer class="container mt-5">
        <div class="text-center">
          <p style="margin-bottom: 0;">Copyright 2023, TekkomInterns by Program Studi Teknik Komputer UPI Cibiru</p>
        </div>
      </footer>