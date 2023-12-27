<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2023 &copy; Mazer</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Saugi</a></p>
        </div>
    </div>
</footer>
</div>
</div>
<script src="<?= BASE_URL ?>assets/static/js/components/dark.js"></script>
<script src="<?= BASE_URL ?>assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= BASE_URL ?>assets/compiled/js/app.js"></script>
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