<?= generateDeletionConfirmationHtml('usuário', $usuario['username']) ?>

<form method="post" action="<?= base_url('admin/usuarios/apagar-data') ?>" class="d-flex justify-content-end mt-4">
    <input type="hidden" value="<?= $usuario['id'] ?>" name="usuario_id">
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-trash3"></i> Apagar
    </button>
</form>