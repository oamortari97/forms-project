<form method="post" action="<?= base_url('alterar-data') ?>">

    <div class="mb-3">
        <label for="password" class="form-label">Senha atual</label>
        <input type="password" class="form-control" id="password" name="senha" placeholder="Digite a senha atual" required>
    </div>


    <div class="mb-3">
        <label for="new-password" class="form-label">Nova senha</label>
        <input type="password" class="form-control" id="new-password" name="nova-senha" placeholder="Digite a nova senha" required>
    </div>


    <div class="mb-3">
        <label for="re-new-password" class="form-label">Repetir nova senha</label>
        <input type="password" class="form-control" id="re-new-password" name="re-nova-senha" placeholder="Repita a nova senha" required>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>