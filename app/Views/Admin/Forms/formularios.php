<h3 class="mb-4">Formulários <i class="bi bi-file-earmark-text text-muted"></i></h3>

<div class="d-flex justify-content-end mb-3">
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addFormModal">
        <i class="bi bi-plus-circle"></i> Novo Formulário
    </button>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome do Formulário</th>
            <th scope="col">Data de Criação</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Formulário de Contato</td>
            <td>25/07/2024</td>
            <td>
                <div class="btn-group" role="group" aria-label="Ações do usuário">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editFormModal">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFormModal">
                        <i class="bi bi-trash3"></i>
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#shareFormModal">
                        <i class="bi bi-share-fill"></i>
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</div>

<!-- MODAL DE CRIAR FORMULÁRIO -->
<div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFormModalLabel">Criar Novo Formulário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="addFormName" class="form-label">Nome do Formulário</label>
                        <input type="text" class="form-control" id="addFormName" placeholder="Digite o nome do formulário" required>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="addFormInicial" class="form-label">Data Inicial</label>
                                <input type="date" class="form-control" id="addFormInicial" placeholder="Escolha a data inicial" required>
                            </div>
                            <div class="col">
                                <label for="addFormFinal" class="form-label">Data Final</label>
                                <input type="date" class="form-control" id="addFormFinal" placeholder="Escolha a data Final" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="addUserGroup" class="form-label">Tipo do Formulário</label>
                        <select class="form-select" id="addUserGroup" aria-label="Default select example">
                            <option value="1">Tipo 1</option>
                            <option value="2">Tipo 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permitir acesso externo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="addUserActive" checked>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE EDIÇÃO -->
<div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="editFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormModalLabel">Editar Formulário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editFormName" class="form-label">Nome do Formulário</label>
                        <input type="text" class="form-control" id="editFormName" placeholder="Digite o nome do formulário" required>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="editFormInicial" class="form-label">Data Inicial</label>
                                <input type="date" class="form-control" id="editFormInicial" placeholder="Escolha a data inicial" required>
                            </div>
                            <div class="col">
                                <label for="editFormFinal" class="form-label">Data Final</label>
                                <input type="date" class="form-control" id="editFormFinal" placeholder="Escolha a data Final" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editUserGroup" class="form-label">Tipo do Formulário</label>
                        <select class="form-select" id="editUserGroup" aria-label="Default select example">
                            <option value="1">Tipo 1</option>
                            <option value="2">Tipo 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Permitir acesso externo</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="editUserActive" checked>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE EXCLUIR -->
<div class="modal fade" id="deleteFormModal" tabindex="-1" aria-labelledby="deleteFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteFormModalLabel">Excluir Formulário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja excluir o formulário de Contato?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Sim</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA COMPARTILHAR -->
<div class="modal fade" id="shareFormModal" tabindex="-1" aria-labelledby="shareFormModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareFormModalLabel">Compartilhar Formulário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="userShared" class="form-label">Compartilhar Com</label>
                        <select class="form-select" id="userShared">
                            <option selected>Escolha...</option>
                            <option value="1">Usuário 1</option>
                            <option value="2">Usuário 2</option>
                            <option value="3">Usuário 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="shareLink" class="form-label">Link</label>
                        <input type="text" class="form-control" id="shareLink" value="https://teste.com/formulario" readonly>
                        <button type="button" class="btn btn-outline-info mt-2" onclick="copyLink()"><i class="bi bi-copy"></i></button>
                    </div>
                    <button type="submit" class="btn btn-success">Compartilhar</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function copyLink() {
        let copyText = document.getElementById("shareLink");
        copyText.select();
        document.execCommand("copy");
    }
</script>