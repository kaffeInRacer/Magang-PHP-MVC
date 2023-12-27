<?php
$currentURL = $_SERVER['REQUEST_URI'];
$pathSegments = explode('/', $currentURL);
$uri = $pathSegments[2];
$controller = new Controller;
$based = $controller->GlobalFiture();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/icon.png" />
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/extensions/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Tambahkan Font Awesome CSS -->
  <title><?php
          if (!isset($data)) {
            echo "TekkomInterns | Magang";
          } else {
            echo $data;
          }
          ?>
  </title>

</head>

<body>
  <!-- Navbar -->
  <nav class="container navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand col-md-2 col-sm-4" href="home">
      <img src="<?= BASE_URL ?>assets/images/logo.png" class="logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto"> <!-- ms-auto untuk mengatur tombol login di sebelah kanan -->
        <li class="nav-item <?php if ($uri === 'dashboard') echo 'active'; ?>">
          <a class="nav-link" href="dashboard">Program</a>
        </li>
        <li class="nav-item <?php if ($uri === 'kegiatan') echo 'active'; ?> ">
          <a class="nav-link" href="kegiatan">Kegiatan Saya</a>
        </li>
        <?php
        if (!$based) {
          echo '<li class="nav-item ' . ($uri === 'mandiri' ? 'active' : '') . '">
              <a class="nav-link" href="mandiri">Magang Mandiri</a>
          </li>';
        }
        ?>
        <li class="nav-item dropdown">
          <!-- Tombol Dropdown Profil -->
          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bars"></i> Menu
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
            <?php
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
              echo '<li><a class="dropdown-item" href="' . BASE_URL . 'admin">Admin</a></li>';
            }
            ?>
            <li><a class="dropdown-item" href="action_logout">Logout</a></li>
            <!-- <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Keluar</a></li> -->
          </ul>
        </li>
      </ul>
    </div>
  </nav>