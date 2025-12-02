<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">
        Usuários
        <span class="fs-4 mx-2">
            👤
        </span>
    </h3>

    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-outline-success" id="addUserBtn">
            <i class="bi bi-plus-circle"></i> Novo Usuário
        </button>
    </div>
</div>

<div class="alert alert-primary" role="alert">
    <strong>Importante:</strong> Não é possível excluir usuários que possuem formulários associados. Utilize a opção de inativar.
</div>

<table class="table table-hover mt-3" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Usuário</th>
            <th scope="col">Email</th>
            <th scope="col">Grupo</th>
            <th scope="col">Ativo</th>
            <th scope="col">Admin</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario) { ?>
            <tr>
                <th scope="row"><?= $usuario['id'] ?></th>
                <td><?= $usuario['name'] . ' ' . $usuario['surname'] ?></td>
                <td><?= $usuario['username'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td><?= $usuario['group_name'] ?></td>
                <td><?= getBooleanIcon($usuario['active']) ?></td>
                <td><?= getBooleanIcon($usuario['admin']) ?></td>
                <td>
                    <?php if ((int) $usuario['id'] !== 1) { ?>
                        <div class="btn-group" role="group" aria-label="Ações do usuário">

                            <button type="button" class="btn btn-outline-secondary btn-sm editUserBtn" data-user-id="<?= $usuario['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <?php if ($usuario['form_count'] > 0) { ?>
                                <?php if ($usuario['active'] == '0') {  ?>
                                    <button type="button" class="btn btn-outline-success btn-sm toggleUserBtn" data-user-id="<?= $usuario['id'] ?>" data-user-value="1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ativar">
                                        <i class="bi bi-person-check"></i>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm toggleUserBtn" data-user-id="<?= $usuario['id'] ?>" data-user-value="0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Inativar">
                                        <i class="bi bi-person-slash"></i>
                                    </button>
                                <?php } ?>
                            <?php } else { ?>
                                <button type="button" class="btn btn-outline-danger btn-sm deleteUserBtn" data-user-id="<?= $usuario['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>