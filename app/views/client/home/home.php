<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/icon.png" />
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Tambahkan Font Awesome CSS -->
  <title>Tekkom Interns | Home</title>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?= BASE_URL ?>home">
        <img src="<?= BASE_URL ?>assets/images/logo.png" alt="Bootstrap" width="200" height="50">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Program</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Testimonial</a>
          </li>
        </ul>
      </div>
      <div class="ps-5">
        <?php
        if (isset($_SESSION['user'])) {
          echo '<a class="btn btn-info" href="' . BASE_URL . 'dashboard" role="button">Dashboard</a>';
        } else {
          echo '<a class="btn btn-primary" href="' . BASE_URL . 'login" role="button">Login</a>';
        }
        ?>
      </div>

    </div>
  </nav>


  <!-- Hero Section -->
  <div class="container mb-5">
    <div class="row align-items-center">
      <!-- Konten di sebelah kiri -->
      <div class="col-lg-6 col-md-6 col-sm-6">
        <h5>Business Solution</h5>
        <h1>Buka peluang karirmu lebih luas lagi</h1>
        <p>Magang Berkualitas, Karir yang Lebih Luas. Temukan Semua Ini di Tekkom Interns! Bergabunglah Sekarang dan Mulailah Perjalanan Karirmu!</p>
        <a href="<?= BASE_URL ?>register" class="btn btn-primary">Daftar</a>
        <a href="#" class="btn btn-outline-primary">Pelajari Lebih Lanjut</a>
      </div>

      <!-- Gambar di sebelah kanan -->
      <div class="col-lg-6 col-md-6 col-sm-6">
        <img src="<?= BASE_URL ?>assets/images/heroimage.png" alt="Hero Image" class="img-fluid">
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div class="container mt-5 text-center">
    <!-- Judul Feature Section -->
    <h5 class="mt-5">Program</h5>
    <h2 class="mt-2 mb-3">Yang kami tawarkan</h2>
    <p class="mb-5">Pelajari tiap program yang kami tawarkan<br>membantu kamu menggapai karir</p>

    <!-- 4 Gambar dengan Keterangannya -->
    <div class="row mt-5">
      <div class="col-md-3 col-sm-3">
        <img src="<?= BASE_URL ?>assets/images/magangpartner.svg" alt="Fitur 1" class="img-fluid mb-2">
        <h3>Magang<br>Partnership</h3>
        <p>Magang di perusahaan yang telah bekerjasama dengan Teknik Komputer</p>
      </div>
      <div class="col-md-3 col-sm-3">
        <img src="<?= BASE_URL ?>assets/images/magangpeneliti.svg" alt="Fitur 2" class="img-fluid mb-2">
        <h3>Magang<br>Penelitian</h3>
        <p>Magang bersama dosen dalam penelitian</p>
      </div>
      <div class="col-md-3 col-sm-3">
        <img src="<?= BASE_URL ?>assets/images/magangmandiri.svg" alt="Fitur 3" class="img-fluid mb-2">
        <h3>Magang<br>Mandiri</h3>
        <p>Tentukan perusahaan impianmu kami bantu rekomendasikan</p>
      </div>
      <div class="col-md-3 col-sm-3">
        <img src="<?= BASE_URL ?>assets/images/persiapankarir.svg" alt="Fitur 4" class="img-fluid mb-2">
        <h3>Persiapan<br>Karir</h3>
        <p>Membantu kamu dalam persiapan karir untuk masa depan</p>
      </div>
    </div>
  </div>

  <!-- About Section -->
  <div class="container mt-5">
    <div class="row align-items-center">
      <!-- Gambar di sebelah kiri -->
      <div class="col-lg-6 col-md-6 col-sm-6">
        <img src="<?= BASE_URL ?>assets/images/aboutimage.png" alt="Hero Image" class="img-fluid">
      </div>

      <!-- Konten di sebelah kanan -->
      <div class="col-lg-6 col-md-6 col-sm-6">
        <h5 class="mb-3">Tentang TekkomInterns</h5>
        <h1 class="mb-3">Kami membuka peluang</h1>
        <p class="mb-3">Dengan komitmen kami untuk memberikan pengalaman magang yang mendalam, kami mengundang Anda untuk meraih impian Anda dan membuka lembaran baru dalam perjalanan karir Anda.</p>
        <p>Di sini, Anda tidak hanya belajar, tetapi juga terlibat dalam proyek-proyek bermakna yang memberikan wawasan praktis dan keterampilan yang dicari oleh industri.</p>
        <a href="#" class="btn btn-primary">Daftar Sekarang</a>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <div class="container text-center">
    <!-- Judul Contact Section -->
    <h5 class="mt-5">Honorable Mentions</h5>
    <h2 class="mt-2">Alumni Interns Terbaik</h2>
    <p class="mb-5">Para alumni TekkomInterns terbaik yang telah direkrut oleh perusahaan partner kami</p>

    <!-- 4 Gambar dengan Ikon dan Keterangan Kontak Person -->
    <div class="row mt-5">
      <div class="col-md-3">
        <img src="<?= BASE_URL ?>assets/images/alumni1.png" alt="Kontak 1" class="img-fluid mb-2">
        <h5>Mochamad Aldi Sidik Maulana</h5>
        <p>
          Engineer<br>
          PT Telkom Indonesia<br>
          <i class="far fa-envelope"></i> <a href="mailto:aldisidikmaulana@gmail.com"></a>
          <i class="fas fa-phone"></i> <a href="mailto:aldisidikmaulana@gmail.com"></a>
        </p>
      </div>
      <div class="col-md-3">
        <img src="<?= BASE_URL ?>assets/images/alumni2.png" alt="Kontak 2" class="img-fluid mb-2">
        <h5>Tengku Juansyah</h5>
        <p>
          Designer<br>
          Suitmedia<br>
          <i class="far fa-envelope"></i> <a href="mailto:tengkujuansyah@gmail.com"></a>
          <i class="fas fa-phone"></i> <a href="mailto:tengkujuansyah@gmail.com"></a>
        </p>
      </div>
      <div class="col-md-3">
        <img src="<?= BASE_URL ?>assets/images/alumni3.png" alt="Kontak 3" class="img-fluid mb-2">
        <h5>Ardi Rahman Sidiq</h5>
        <p>
          Web Developer<br>
          SocaAI<br>
          <i class="far fa-envelope"></i> <a href="mailto:ardirahman@gmail.com"></a>
          <i class="fas fa-phone"></i> <a href="mailto:ardirahman@gmail.com"></a>
        </p>
      </div>
      <div class="col-md-3">
        <img src="<?= BASE_URL ?>assets/images/alumni4.png" alt="Kontak 4" class="img-fluid mb-2">
        <h5>Satria Arya Respati</h5>
        <p>
          Full Stack Developer<br>
          PT NCI<br>
          <i class="far fa-envelope"></i> <a href="mailto:satriaarya@gmail.com"></a>
          <i class="fas fa-phone"></i> <a href="mailto:satriaarya@gmail.com"></a>
        </p>
      </div>
    </div>
  </div>

  <!-- Testimonial Section -->
  <div class="container mb-5">
    <!-- Judul dan Deskripsi Testimonial Section -->
    <h1 class="mt-5">Kata mereka tentang TekkomInterns</h1>
    <p class="lead">Cerita menarik dari para alumni TekkomInterns.</p>

    <!-- 3 Testimoni -->
    <div class="row mt-4">
      <div class="col-md-4 col-sm-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="rating">
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
            </div>
            <p class="card-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare."</p>
            <img src="<?= BASE_URL ?>assets/images/Testi1.png" alt="Profil 1" class="img-fluid rounded-circle mb-3" style="width: 80px;">
            <h6 class="card-title">Ardi Rahman Sidiq</h6>
            <p>Tekkom 2020</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="rating">
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
            </div>
            <p class="card-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare."</p>
            <img src="<?= BASE_URL ?>assets/images/Testi2.png" alt="Profil 2" class="img-fluid rounded-circle mb-3" style="width: 80px;">
            <h6 class="card-title">Tengku Juansyah</h6>
            <p>Tekkom 2020</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="rating">
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
              <span class="fas fa-star text-warning"></span>
            </div>
            <p class="card-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare."</p>
            <img src="<?= BASE_URL ?>assets/images/Testi3.png" alt="Profil 3" class="img-fluid rounded-circle mb-3" style="width: 80px;">
            <h6 class="card-title">Satria Arya Respati</h6>
            <p>Tekkom 2020</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="container cta-section">
    <div class="row align-items-center" style="margin:0px">
      <!-- Sebelah Kiri (Judul dan Deskripsi) -->
      <div class="col-md-8 cta-content">
        <h2 class="cta-title">Siap memulai jenjang karir lebih awal?</h2>
        <p class="cta-description">Daftar TekkomInterns sekarang, buka peluang karir lebih luas, temukan kesempatanmu!</p>
      </div>

      <!-- Sebelah Kanan (Tombol) -->
      <div class="col-md-4 text-center">
        <a href="#" class="btn btn-primary btn-lg cta-button">Daftar Sekarang</a>
      </div>
    </div>
  </div>

  <!-- FAQ Section -->
  <div class="container mt-5">
    <!-- Judul FAQ Section -->
    <h5 class="text-center mb-2">FAQ'S</h5>
    <h2 class="text-center mb-5">Temukan jawaban yang sering ditanyakan</h2>

    <!-- Pertanyaan dan Jawaban (Dropdown) -->
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Apa itu Tekkom Interns?
            </button>
          </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            Tekkom Interns adalah platform khusus untuk mahasiswa Teknik Komputer Universitas Pendidikan Indonesia, untuk mencari peluang dan berbagi aspirasi berkarir, dengan harapan dapat menjadikan alumni Teknik Komputer yang unggul dan pelopor.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Bagaimana saya mengajukan proses Magang Mandiri?
            </button>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus ornare in eget mauris. Porttitor semper sed nisi ac adipiscing vitae. Lobortis imperdiet ornare eleifend nisl ut auctor. Ornare etiam neque elementum mattis ultrices.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingThree">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Berkas-berkas apa saja yang perlu dipersiapkan?
            </button>
          </h5>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus ornare in eget mauris. Porttitor semper sed nisi ac adipiscing vitae. Lobortis imperdiet ornare eleifend nisl ut auctor. Ornare etiam neque elementum mattis ultrices.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingFour">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              Apakah terdapat minimum semester untuk mendaftar?
            </button>
          </h5>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
          <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus ornare in eget mauris. Porttitor semper sed nisi ac adipiscing vitae. Lobortis imperdiet ornare eleifend nisl ut auctor. Ornare etiam neque elementum mattis ultrices.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingFive">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              Apakah program ini berbayar?
            </button>
          </h5>
        </div>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
          <div class="card-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Risus ornare in eget mauris. Porttitor semper sed nisi ac adipiscing vitae. Lobortis imperdiet ornare eleifend nisl ut auctor. Ornare etiam neque elementum mattis ultrices.
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="container mt-5">
      <div class="text-center">
        <p style="margin-bottom: 0;">Copyright 2023, TekkomInterns by Program Studi Teknik Komputer UPI Cibiru</p>
      </div>
    </footer>