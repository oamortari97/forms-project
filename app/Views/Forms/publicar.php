<div class="d-flex flex-column align-items-center justify-content-center">
    <div class="text-danger" style="font-size:2.5rem">
        <div class="alert-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
    </div>
    <div role="alert" aria-live="assertive" class="text-center">
        <div class="mb-2"><strong>Tem certeza de que deseja publicar este formulário?</strong></div>
        <div>Uma vez publicado, o formulário não poderá ser alterado ou excluído.</div>
    </div>
</div>

<form method="post" action="<?= base_url('formularios/publicar-data') ?>" class="d-flex justify-content-end mt-4">
    <input type="hidden" value="<?= $formulario['id'] ?>" name="form_id">
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-trash3"></i> Publicar
    </button>
</form>