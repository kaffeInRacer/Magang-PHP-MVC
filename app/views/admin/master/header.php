<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vertical Navbar - Mazer Admin Dashboard</title>




    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/compiled/css/iconly.css">
    <?php if (!empty($data)) : ?>
        <?php foreach ($data as $css) : ?>
            <link rel="stylesheet" href="<?php echo $css; ?>"><?php echo PHP_EOL; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>
    <script src="<?= BASE_URL ?>assets/static/js/initTheme.js"></script>
    