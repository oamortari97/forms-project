<form method="post" action="<?= base_url('formularios/novo-data') ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nome do Formulário</label>
        <input type="text" class="form-control" id="name" name="nome" placeholder="Digite o nome do formulário" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Descrição do Formulário</label>
        <input type="text" class="form-control" id="description" name="descricao" placeholder="Digite uma descrição para o formulário" required>
    </div>
    <div class="mb-3">
        <div class="row">
            <div class="col">
                <label for="starts" class="form-label">Data Inicial</label>
                <input type="date" class="form-control" id="starts" name="data_inicial" placeholder="Escolha a data inicial" required>
            </div>
            <div class="col">
                <label for="ends" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="ends" name="data_final" placeholder="Escolha a data Final" required>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="share">Permitir acesso com link <button type="button" class="btn btn-sm btn-outline-primary mx-1" style="padding: 0rem 0.4rem" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Permite que qualquer usuário com o link tenha acesso ao formulário."><i class="bi bi-info"></i></button></label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="share" name="acesso_externo" checked>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>

<script>
    $('[data-bs-toggle="tooltip"]').each(function() {
        new bootstrap.Tooltip(this);
    });
</script>