<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/images/icon.png" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <title>TekkomInterns | Register</title>
</head>

<body>

  <div class="container register-container">
    <div class="card register-form">
      <div class="card-body">
        <!-- Logo Register -->
        <div class="register-logo">
          <img src="<?= BASE_URL ?>assets/images/logo.png" alt="Logo" width="150">
        </div>

        <div class="mt-2 text-center">
          <h2>Daftar sekarang!</h2>
          <p>Untuk akses dashboard-mu</p>
          <?php
          Flasher::Message();
          ?>
        </div>
        <form method="POST" enctype="multipart/form-data" action="<?= BASE_URL ?>register/store">
          <div class="mb-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="nama lengkap" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="number" class="form-control" id="nim" name="nim" placeholder="NIM" required>
          </div>
          <div class="mb-3">
            <input type="tel" class="form-control" id="telp" name="telp" placeholder="Telepon" required>
          </div>
          <div class="mb-3">
            <select class="form-control" id="gender" name="gender" required>
              <option value="" disabled selected>Jenis Kelamin</option>
              <option value="L">Pria</option>
              <option value="P">Wanita</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-block w-100">Daftar Sekarang</button>
        </form>
      </div>
    </div>
  </div>