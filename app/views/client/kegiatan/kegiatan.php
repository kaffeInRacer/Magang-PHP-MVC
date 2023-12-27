<?php if (empty($data)) : ?>
  <div class="row mt-5">
    <div class="col-md-12 text-center">
      <img src="<?= BASE_URL ?>assets/images/deactive.png" alt="Gambar" class="img-fluid">
      <h2 class="mt-3">Kamu tidak memiliki kegiatan aktif apapun</h2>
    </div>
  </div>
<?php else : ?>
  <?php foreach ($data as $datas) : ?>
    <?php
    $image = '';
    if ($datas['image'] === '') {
      $image = 'storage/image/upi.png';
    } else {
      $image = $datas['image'];
    }
    ?>
    <div class="container mt-5">
      <h3>Kegiatan aktif-mu dapat dipantau disini</h3>
      <div class="card text-break" style="max-width: 400px;">
        <div class="card-body">
          <div class="d-flex align-items-center mb-4">
            <img class="card-img-top w-25 mr-3" src="<?= BASE_URL . $image ?>" alt="<?= $datas['title'] ?>" />
            <div>
              <h4 class="card-title"><?= $datas['title'] ?></h4>
              <div class="d-flex">
                <p class="card-text font-weight-bold"><?= $datas['author'] . ' • ' . $datas['type'] ?></p>
              </div>
            </div>
          </div>
          <div>
            <?php if ($datas['type'] !== 'mandiri') { ?>
              echo '<p class="font-weight-bold">Alamat</p>
              <p class="card-text"><?= $datas['address'] ?></p>';
          </div>
          <hr> <!-- Add another horizontal line for separation -->
          <div>
            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalId">
              Deskripsi</button>
          <?php } ?>
          <!-- Modal -->
          <div class="modal fade" id="modalId" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"><?= $datas['description'] ?></div>
              </div>
            </div>
          </div>
          </div>
          <button class="btn btn-success">SEDANG BERLANGSUNG</button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<!-- Footer -->
<footer class="container mt-5">
  <div class="text-center">
    <p style="margin-bottom: 0;">Copyright 2023, TekkomInterns by Program Studi Teknik Komputer UPI Cibiru</p>
  </div>
</footer>



<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->