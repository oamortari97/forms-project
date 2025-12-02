<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/external/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/icons/font/bootstrap-icons.min.css') ?>">

    <title><?= getenv('APPL_NAME') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/icone.svg') ?>">
</head>

<body style="background-color: #f8f8f8">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg nav-bar bg-success">
        <div class="container-fluid mx-2">
            <a class="navbar-brand text-white" href="#">
                <img src="<?= base_url('assets/img/logo-branca.svg') ?>" alt="" srcset="" style="height: 2.5rem">
            </a>
        </div>
    </nav>

    <!-- Form Container -->
    <div class="container my-4 bg-white p-5" style="border-radius: .3rem; border: 1px solid #d3d3d3" id="load-view">
        <?= $view ?>
    </div>

    <div id="base-url" data-base-url="<?= base_url() ?>"></div>
    <script src="<?= base_url('assets/js/external/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/external/bootstrap.bundle.min.js') ?>"></script>
    <?= view('alerts') ?>

    <?php if (isset($scripts)) { ?>
        <?php foreach ($scripts as $script) { ?>
            <script src="<?= $script ?>"></script>
        <?php } ?>
    <?php } ?>
</body>

</html>