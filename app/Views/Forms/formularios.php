<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">
        Formulários
        <span class="fs-4 mx-2">
            📃
        </span>
    </h3>

    <?php if (session()->get('usuario')['admin'] || session()->get('usuario')['group']['create'] == 1) { ?>
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-outline-success" id="addFormBtn">
                <i class="bi bi-plus-circle"></i> Novo Formulário
            </button>
        </div>
    <?php } ?>
</div>

<div class="alert alert-primary" role="alert">
    <strong>Importante:</strong> Para publicar um formulário, a data final deve ser maior que a data atual.
</div>

<table class="table mt-3 table-hover" id="table-dt">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Início</th>
            <th scope="col">Fim</th>
            <th scope="col">Acesso com link</th>
            <th scope="col">Publicado</th>
            <th scope="col">Respostas</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($formularios as $formulario) { ?>
            <tr>
                <th scope="row"><?= $formulario['id'] ?></th>
                <td><?= $formulario['name'] ?></td>
                <td><?= formatDate($formulario['starts']) ?></td>
                <td><?= formatDate($formulario['ends']) ?></td>
                <td><?= getBooleanIcon($formulario['share']) ?></td>
                <td><?= getBooleanIcon($formulario['posted']) ?></td>
                <td><?= $formulario['response_count'] ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Ações do usuário">
                        <?php if ($formulario['posted'] == 1) { ?>

                            <?php if (session()->get('usuario')['admin'] || session()->get('usuario')['group']['edit'] == 1) { ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item editFormBtn" href="#" data-action="edit" data-form-id="<?= $formulario['id'] ?>">Editar</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('formularios/modelar/' . $formulario['id']) ?>">Modelar</a></li>
                                </ul>
                            <?php } ?>

                            <?php if (session()->get('usuario')['admin'] || session()->get('usuario')['group']['read'] == 1) { ?>
                                <a type="button" class="btn btn-outline-warning btn-sm responseFormBtn" href="<?= base_url('formularios/respostas/' . $formulario['id']) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver respostas">
                                    <i class="bi bi-chat-dots"></i>
                                </a>

                                <a type="button" class="btn btn-outline-primary btn-sm responseFormBtn" href="<?= base_url('responder/' . $formulario['id']) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Responder">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>

                                <a type="button" class="btn btn-outline-success btn-sm" href="<?= base_url('formularios/compartilhar/') . $formulario['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Compartilhar">
                                    <i class="bi bi-share-fill"></i>
                                </a>
                            <?php } ?>

                        <?php } else { ?>

                            <?php if (session()->get('usuario')['admin'] || session()->get('usuario')['group']['edit'] == 1) { ?>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item editFormBtn" href="#" data-action="edit" data-form-id="<?= $formulario['id'] ?>">Editar</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('formularios/modelar/' . $formulario['id']) ?>">Modelar</a></li>
                                </ul>
                            <?php } ?>

                            <?php if ((session()->get('usuario')['admin'] || session()->get('usuario')['group']['read'] == 1) && ($formulario['response_count'] > 0)) { ?>
                                <a type="button" class="btn btn-outline-warning btn-sm responseFormBtn" href="<?= base_url('formularios/respostas/' . $formulario['id']) ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver respostas">
                                    <i class="bi bi-chat-dots"></i>
                                </a>
                            <?php } ?>

                            <?php if ((session()->get('usuario')['admin'] || session()->get('usuario')['group']['delete'] == 1) && ($formulario['response_count'] == 0)) { ?>
                                <button type="button" class="btn btn-outline-danger btn-sm deleteFormBtn" data-form-id="<?= $formulario['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            <?php } ?>

                            <?php if (session()->get('usuario')['admin'] || session()->get('usuario')['group']['edit'] == 1) { ?>
                                <?php if (date('Y-m-d', strtotime($formulario['ends'])) > date('Y-m-d')) { ?>
                                    <button type="button" class="btn btn-outline-success btn-sm postFormBtn" data-form-id="<?= $formulario['id'] ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Publicar">
                                        <i class="bi bi-send-check"></i>
                                    </button>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    </div>
                </td>
            <?php } ?>
            </tr>
    </tbody>
</table>
</div>

<script>
    function copyLink() {
        let copyText = document.getElementById("shareLink");
        copyText.select();
        document.execCommand("copy");
    }
</script>