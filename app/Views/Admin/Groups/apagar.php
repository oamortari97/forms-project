<?= generateDeletionConfirmationHtml('grupo', $grupo['name']) ?>

<form method="post" action="<?= base_url('admin/grupos/apagar-data') ?>" class="d-flex justify-content-end mt-4">
    <input type="hidden" value="<?= $grupo['id'] ?>" name="grupo_id">
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-trash3"></i> Apagar
    </button>
</form>