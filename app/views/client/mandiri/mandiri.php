<div class="container-fluid" style="padding:0px">
  <div class="row daftar-container">
    <div class="col-md-7 col-sm-7">
      <div class="row">
        <div class="col-md-12 daftar-massages">
          <blockquote class="blockquote">
            <h3 class="mb-3" style="font-weight: bold;">Isi dengan Lengkap Form Magang Mandiri</h3>
            <p>Agar proses magang-mu dibantu lebih cepat</p>
          </blockquote>
        </div>
      </div>
    </div>

    <div class="col-md-5 col-sm-5 daftar-features">
      <div class="login-form col-md-12">
        <!-- Form Login -->
        <form method="POST" action="<?= BASE_URL ?>mandiri/insert">
          <h2>Isi Form Magang Mandiri</h2>
          <p>Harap isi dengan lengkap</p>
          <div class="mb-3">
            <input type="text" class="form-control" id="mitra" name="mitra" placeholder="Perusahaan Mitra" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Posisi yang diajukan" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" id="pic" name="pic" placeholder="Nama PIC" required>
          </div>
          <div class="mb-3">
            <input type="number" class="form-control" id="kontak" name="kontak" placeholder="Kontak PIC" required>
          </div>
          <button name="daftar" type="submit" class="btn btn-primary btn-block">Kirim Berkas</button>
        </form>
      </div>
    </div>
  </div>
</div>