<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">Compartilhar
        <span class="fs-4 mx-2">
            🔗
        </span>
    </h3>

    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-outline-success" id="addShareBtn" data-form-id="<?= $formulario['id'] ?>">
            <i class="bi bi-plus-circle"></i> Criar Link Autenticado
        </button>
    </div>
</div>

<div class="alert alert-primary" role="alert">
    <strong>Importante:</strong> Você está compartilhando o formulário '<?= $formulario['name'] ?>'.
</div>

<?php if ($formulario['share'] == 1) { ?>
    <div class="alert alert-primary" role="alert">
        <strong>Importante:</strong> Este formulário permite acesso direto, compartilhe o link:
        <div class="input-group mt-3">
            <input type="text" class="form-control" id="urlInput" value="<?= base_url('responder/externo/' . $formulario['id']) ?>" readonly>
            <button class="btn btn-success" id="copyButton">Copiar <i class="bi bi-copy"></i></button>
        </div>
    </div>

<?php } ?>

<table class="table table-hover mt-3" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Usuário</th>
            <th scope="col">Acesso</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($acessos as $acesso) { ?>
            <tr>
                <th scope="row"><?= $acesso['id'] ?></th>
                <td><?= $acesso['name'] . ' ' . $acesso['surname'] ?></td>
                <td><?= $acesso['username'] ?></td>
                <td><?= $acesso['access_hash'] ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Ações do usuário">
                        <?php if ($acesso['response_count'] == 0) { ?>
                            <button type="button" class="btn btn-outline-danger btn-sm deleteShareBtn" data-share-id="<?= $acesso['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </button>
                        <?php } ?>
                        <button type="button" class="btn btn-outline-success btn-sm copyShareBtn" data-share-hash="<?= $acesso['access_hash'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copiar link autenticado">
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                </td>
            <?php } ?>
            </tr>
    </tbody>
</table>