<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">
        Grupos
        <span class="fs-4 mx-2">
            👥
        </span>
    </h3>

    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-outline-success" id="addGroupBtn">
            <i class="bi bi-plus-circle"></i> Novo Grupo
        </button>
    </div>
</div>

<div class="alert alert-primary" role="alert">
    <strong>Importante:</strong> Grupos com usuários não podem ser excluídos.
</div>

<table class="table table-hover mt-3" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Ver</th>
            <th scope="col">Criar</th>
            <th scope="col">Editar</th>
            <th scope="col">Excluir</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($grupos as $grupo) { ?>
            <tr>
                <th scope="row"><?= $grupo['id'] ?></th>
                <td><?= $grupo['name'] ?></td>
                <td><?= getBooleanIcon($grupo['read']) ?></td>
                <td><?= getBooleanIcon($grupo['create']) ?></td>
                <td><?= getBooleanIcon($grupo['edit']) ?></td>
                <td><?= getBooleanIcon($grupo['delete']) ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Ações do usuário">
                        <button type="button" class="btn btn-outline-secondary btn-sm editGroupBtn" data-group-id="<?= $grupo['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <?php if (!isset($grupo['usuarios']) && empty($grupo['usuarios'])) { ?>
                            <button type="button" class="btn btn-outline-danger btn-sm deleteGroupBtn" data-group-id="<?= $grupo['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </button>
                        <?php } ?>
                    </div>
                </td>
            <?php } ?>
            </tr>
    </tbody>
</table>
</div>