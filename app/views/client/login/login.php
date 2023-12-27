<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="assets/images/icon.png" />
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <title>TekkomInterns | Login</title>
</head>

<body>

  <div class="container-fluid" style="padding:0px">
    <div class="row login-container">
      <div class="col-md-8 col-sm-8" style="padding:0px;background:linear-gradient(151deg, #5BB2ED 12.51%, #0595F4 85.37%);">
        <div class="row">
          <a class="col-md-12 login-logo" href="landingpage">
            <img src="<?= BASE_URL ?>assets/images/lg_login.png" alt="Logo" width="200">
          </a>
          <div class="col-md-12 login-quotes">
            <blockquote class="blockquote">
              <p class="mb-0" style="color: #ffffff; font-weight: bold; font-style: italic;">Opportunities don’t happen, you create them.</p>
              <footer class="blockquote-footer" style="color: #ffffff;">Anonim</footer>
            </blockquote>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-4 login-features">
        <div class="login-form col-md-12 p-3">
          <div class="text-center">
            <h2>Halo!</h2>
            <p>Login untuk akses dasbor-mu</p>
            <?php Flasher::Message(); ?>
          </div>
          <!-- Form Login -->
          <form method="POST" action="<?= BASE_URL ?>login/action_login">
            <div class="mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <!-- <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Ingat Saya</label>
            </div> -->
            <input name="login" type="submit" class="btn btn-primary btn-block w-100" value="Login">
            <!-- <div class="mt-3 text-center">
              Belum punya akun? <a href="#">Register</a>
            </div> -->
            <p class="mt-3">Belum punya akun?</p>
            <a href="register" class="btn btn-outline-primary btn-block w-100">Daftar</a>
          </form>
        </div>
      </div>
    </div>
  </div>