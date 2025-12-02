<form method="post" action="<?= base_url('admin/usuarios/novo-data') ?>">
    <div class="row mb-3">
        <div class="col">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="nome" placeholder="Digite o nome" required>
        </div>
        <div class="col">
            <label for="surname" class="form-label">Sobrenome</label>
            <input type="text" class="form-control" id="surname" name="sobrenome" placeholder="Digite o sobrenome" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Nome de Usuário</label>
        <input type="text" class="form-control" id="username" name="usuario" placeholder="Digite o nome de usuário" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite a senha" required>
    </div>
    <div class="mb-3">
        <label for="group" class="form-label">Grupo</label>

        <select class="form-select select-js" id="group" name="grupo">
            <option selected disabled value="">Selecionar grupo</option>

            <?php foreach ($grupos as $grupo) { ?>
                <option value="<?= $grupo['id'] ?>"><?= $grupo['name'] ?></option>
            <?php } ?>

        </select>

    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active" name="ativo" checked>
                    <label class="form-check-label" for="active">Ativo</label>
                </div>
            </div>
            <div class="col">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="admin" name="admin">
                    <label class="form-check-label" for="admin">Administrador</label>
                </div>
            </div>
        </div>
    </div>

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