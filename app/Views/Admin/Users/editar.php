<form method="post" action="<?= base_url('admin/usuarios/editar-data') ?>" id="formUsuario">
    <div class="row mb-3">
        <div class="col">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="nome" value="<?= $usuario['name'] ?>">
        </div>
        <div class="col">
            <label for="surname" class="form-label">Sobrenome</label>
            <input type="text" class="form-control" id="surname" name="sobrenome" value="<?= $usuario['surname'] ?>">
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>">
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Nome de Usuário</label>
        <input type="text" class="form-control" id="username" name="usuario" value="<?= $usuario['username'] ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="senha" placeholder="Alterar senha...">
    </div>
    <div class="mb-3">
        <label for="group" class="form-label">Grupo</label>

        <select class="form-select" id="group" name="grupo">
            <?php foreach ($grupos as $grupo) { ?>
                <option value="<?= $grupo['group_id'] ?>" <?= $grupo['group_id'] == $usuario['group'] ? ' selected ' : '' ?>><?= $grupo['group_name'] ?></option>
            <?php } ?>
        </select>

    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" value="1" name="ativo" <?= $usuario['active'] == 1 ? " checked " : "" ?>>
                    <label class="form-check-label" for="active">Ativo</label>
                </div>
            </div>
            <div class="col">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="admin" value="1" name="admin" <?= $usuario['admin'] == 1 ? " checked " : "" ?>>
                    <label class="form-check-label" for="admin">Administrador</label>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('select').each(function() {
            new SlimSelect({
                select: this
            });
        });
    });
</script>