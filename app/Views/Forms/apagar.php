<?= generateDeletionConfirmationHtml('formulário', $formulario['form_name']) ?>

<form method="post" action="<?= base_url('formularios/apagar-data') ?>" class="d-flex justify-content-end mt-4">
    <input type="hidden" value="<?= $formulario['form_id'] ?>" name="form_id">
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-trash3"></i> Apagar
    </button>
</form>