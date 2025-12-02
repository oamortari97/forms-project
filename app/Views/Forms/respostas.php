<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4"><?= $formulario['form_name'] ?>
        <span class="fs-4 mx-2">
            💬
        </span>
    </h3>

    <div>
        <button class="btn btn-outline-success" id="summaryBtn" data-form-id="<?= $formulario['form_id'] ?>">
            <i class="bi bi-list-check"></i> Resultados Resumidos
        </button>
    </div>
</div>

<table class="table table-hover" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Usuário</th>
            <th scope="col">Data</th>
            <th scope="col">Origem</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($respostas as $reposta) { ?>
            <tr>
                <td><?= $reposta['id'] ?></td>
                <td><?= ($reposta['name'] == null ? $reposta['external_user'] : $reposta['name']) ?></td>
                <td><?= formatDate($reposta['response_date'], 'H:i:s') ?></td>
                <td><?= ($reposta['name'] == null ? 'Externo' : 'Interno') ?></td>
                <td>
                    <button class="btn btn-outline-secondary btn-sm responseBtn" data-response-id="<?= $reposta['id'] ?>">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>