<form method="post" action="<?= base_url('admin/usuarios/toggle-data') ?>">
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="text-danger" style="font-size:2.5rem">
            <div class="alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
        </div>
        <div role="alert" aria-live="assertive" class="text-center">
            Você tem certeza que deseja <?= $valor == 0 ? 'inativar' : 'ativar' ?> o usuário <strong><?= $usuario['name'] ?></strong>?
        </div>
    </div>

    <input type="hidden" name="usuario_id" value="<?= $usuario['id'] ?>">
    <input type="hidden" name="valor" value="<?= $valor ?>">

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>