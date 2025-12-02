<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/external/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/icons/font/bootstrap-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/js/external/DataTables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/js/external/SlimSelect/slimselect.css') ?>">

    <title><?= getenv('APPL_NAME') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/icone.svg') ?>">

</head>

<body>
    <div class="container-fluid">
        <div class="row main-nav">
            <div class="flex-column flex-shrink-0 p-3 col-sm-2 sidebar" style="height: 100vh; background: #fff; border-right: 1px solid #d3d3d3;">
                <a href="<?= base_url('/') ?>" class="d-flex justify-content-center align-items-center mb-3 mb-md-0 link-dark text-decoration-none">
                    <img src="<?= base_url('assets/img/logo-forms-bk.png') ?>" width="150rem" alt="">
                </a>

                <hr>

                <form class="mb-3">
                </form>
                <ul class="nav nav-pills flex-column mb-auto responsive-nav">
                    <li class="nav-item">
                        <a href="<?= base_url('/') ?>" class="nav-link <?= (empty(returnMainRoute()) ? "link-active" : "link-dark") ?>" aria-current="page">
                            <i class="bi bi-house"></i>
                            <span class="nav-text">Início</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url("relatorios") ?>" class="nav-link <?= (returnMainRoute() == 'relatorios' ? "link-active" : "link-dark") ?>">
                            <i class="bi bi-bar-chart"></i>
                            <span class="nav-text">Relatórios</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url("formularios") ?>" class="nav-link  <?= (returnMainRoute() == 'formularios' ? "link-active" : "link-dark") ?>">
                            <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-text">Formulários</span>
                        </a>
                    </li>
                    <?php if (session()->get('usuario')['admin']) { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle  <?= returnMainRoute('admin') == 'usuarios' || returnMainRoute('admin') == 'grupos' ? "link-active" : "link-dark"; ?>" id="ajustesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-sliders"></i>
                                <span class="nav-text">Ajustes</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="ajustesDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url("admin/usuarios") ?>">
                                        <i class="bi bi-person"></i>
                                        <span class="nav-text">Usuários</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url("admin/grupos") ?>">
                                        <i class="bi bi-people"></i>
                                        <span class="nav-text">Grupos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>

                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-profile">
                            <i class="bi bi-person me-2"></i>
                        </div>

                        <strong>
                            <?= session()->get('usuario')['username'] ?>
                        </strong>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="<?= base_url('formularios') ?>">Novo formulário...</a></li>
                        <li><a class="dropdown-item" href="#" id="changePassword">Alterar senha</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 content-wrapper main-content" style="height: 100vh; overflow-y:scroll; padding-bottom: 3rem;">
                <div class="container mt-4">
                    <?= $view ?>
                </div>
            </div>
        </div>

        <div class="mobile-button">
            <button class="btn btn-primary menu-toggle" type="button">
                <i class="bi bi-list"></i>
            </button>
            <div class="fs-2 title-barra">
                <i class="bi bi-cursor"></i>
                <span class="text-muted">Forms</span>
            </div>
        </div>
    </div>

    <div class="modal fade" id="defaultModal" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="defaultModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    ...
                </div>
            </div>
        </div>
    </div>
    <div id="base-url" data-base-url="<?= base_url() ?>"></div>
    <script src="<?= base_url('assets/js/external/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/external/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/external/DataTables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/external/SlimSelect/slimselect.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <?= view('alerts') ?>

    <!-- Scripts dinâmicos -->
    <?php if (isset($scripts)) { ?>
        <?php foreach ($scripts as $script) { ?>
            <script src="<?= $script ?>"></script>
        <?php } ?>
    <?php } ?>
</body>

</html>