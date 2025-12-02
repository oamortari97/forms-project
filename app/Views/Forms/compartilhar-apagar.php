<?= generateDeletionConfirmationHtml('compartilhamento com', $acesso['username'] . (empty($acesso['name']) ? ''  : ' (' . $acesso['name'] . ' ' . $acesso['surname'] . ')')) ?>

<form method="post" action="<?= base_url('formularios/compartilhar-apagar-data') ?>" class="d-flex justify-content-end mt-4">
    <input type="hidden" value="<?= $acesso['id'] ?>" name="compartilha_id">
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-trash3"></i> Apagar
    </button>
</form>