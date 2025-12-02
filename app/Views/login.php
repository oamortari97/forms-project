<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getenv('APPL_NAME') . ' - Login' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/icone.svg') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body class="bg-gray">

    <div class="login-wire">
        <div class="login-box">
            <div class="login-left">
                <form class="login-form d-flex-column" method="POST" action="<?= base_url('login') ?>" autocomplete="off">

                    <div class="login-title">Identifique-se!</div>

                    <div class="d-flex-column">
                        <label for="usuario">Usuário</label>
                        <input type="text" name="usuario" id="usuario" value="admin">
                    </div>

                    <div class="d-flex-column">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" value="admin@123">
                    </div>

                    <button type="submit">Entrar</button>
                </form>
            </div>

            <div class="login-right d-flex-column" style="align-items:center; color: #FFF">
                <div class="login-logo">
                    <img src="<?= base_url('assets/img/logo-forms.png') ?>" alt="" srcset="" width="150px">
                </div>

                <div class="login-title">Bem-vindo!</div>
                <div>Por favor, insira suas credenciais para prosseguir.</div>

            </div>

        </div>
    </div>

    <script src="<?= base_url('assets/js/external/jquery-3.6.0.min.js') ?>"></script>
    <?= view('alerts') ?>
</body>

</html>