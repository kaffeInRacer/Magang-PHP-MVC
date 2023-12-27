<script src="<?= BASE_URL ?>assets/extensions/jquery/jquery.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/popper.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/bootstrap.min.js"></script>
<script src="<?= BASE_URL ?>assets/main.js"></script>
<script src="<?= BASE_URL ?>assets/extensions/sweetalert2/sweetalert2.min.js"></script>
<?php
if (!empty($data['sc']) && !empty($data['js'])) {
    foreach ($data['sc'] as $sc) {
        echo '<script src="' . $sc . '"></script>' . PHP_EOL;
    }
    echo '<script>' . $data . '</script>';
} else if (!empty($data['sc'])) {
    foreach ($data['sc'] as $sc) {
        echo '<script src="' . $sc . '"></script>' . PHP_EOL;
    }
} else if (!empty($data['js'])) {
    echo '<script>' . $data . '</script>';
}
?>
</body>

</html>