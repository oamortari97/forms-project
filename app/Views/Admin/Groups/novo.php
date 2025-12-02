<form method="post" action="<?= base_url('admin/grupos/novo-data') ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nome do Grupo</label>
        <input type="text" class="form-control" id="name" name="nome" placeholder="Digite o nome" required>
    </div>
    <div class="mb-3">
        <label for="formularioGroup" class="form-label">Formulários</label>
        <div id="formularioGroup" class="d-flex flex-wrap">
            <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="1" id="read" name="ver">
                <label class="form-check-label" for="read">Ver</label>
            </div>
            <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="1" id="create" name="criar">
                <label class="form-check-label" for="create">Criar</label>
            </div>
            <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" value="1" id="edit" name="editar">
                <label class="form-check-label" for="edit">Editar</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="delete" name="apagar">
                <label class="form-check-label" for="delete">Excluir</label>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>