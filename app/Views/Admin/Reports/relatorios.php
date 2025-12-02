<h3 class="mb-4">
    Relatórios
    <span class="fs-4 mx-2">
        📊
    </span>
</h3>

<table class="table table-hover" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Data</th>
            <th scope="col">Tipo</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0 ?>
        <?php foreach ($formularios as $key => $formulario) { ?>
            <?php $i++ ?>
            <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $formulario['name'] ?></td>
                <td><?= formatDate($formulario['ends']) ?></td>
                <td>Resumo do formulário</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Ações do usuário">
                        <a target="_blank" href="<?= base_url('relatorio/fechamento/' . $formulario['id'] . '/pdf') ?>" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download PDF">
                            <i class="bi bi-filetype-pdf"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>