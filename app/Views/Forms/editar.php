<form method="post" action="<?= $formulario['form_share'] != 1 ? base_url('formularios/editar-data') : base_url('formularios/atualizar-data') ?>">

    <?php if ($formulario['form_share'] != 1) { ?>
        <div class="mb-3">
            <label for="name" class="form-label">Nome do Formulário</label>
            <input type="text" class="form-control" id="name" name="nome" value="<?= $formulario['form_name'] ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição do Formulário</label>
            <input type="text" class="form-control" id="description" name="descricao" value="<?= $formulario['form_description'] ?>">
        </div>
    <?php } ?>

    <div class="mb-3">

        <div class="row">
            <?php if ($formulario['posted'] != 1) { ?>
                <div class="col">
                    <label for="starts" class="form-label">Data Inicial</label>
                    <input type="date" class="form-control" id="starts" name="data_inicial" value="<?= date('Y-m-d', strtotime($formulario['form_starts'])) ?>">
                </div>
            <?php } ?>

            <div class="col">
                <label for="ends" class="form-label">Data Final</label>
                <input type="date" class="form-control" id="ends" name="data_final" value="<?= date('Y-m-d', strtotime($formulario['form_ends'])) ?>">
            </div>
        </div>
    </div>


    <?php if ($formulario['posted'] != 1) { ?>
        <div class="mb-3">
            <label class="form-label" for="share">Permitir acesso externo</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="share" value="1" name="acesso_externo" <?= $formulario['form_share'] == 1 ? " checked " : "" ?>>
            </div>
        </div>
    <?php } ?>

    <?php if ($formulario['posted'] == 1) { ?>
        <div class="mb-3">
            <label class="form-label" for="posted">Publicado</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="posted" value="1" name="form_postado" <?= $formulario['posted'] == 1 ? " checked " : "" ?>>
            </div>
        </div>
    <?php } ?>

    <input type="hidden" name="form_id" value="<?= $formulario['form_id'] ?>">

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>