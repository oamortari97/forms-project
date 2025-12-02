<h3 class="mb-4">Configurações <i class="bi bi-gear text-muted"></i></h3>

<form>
    <div class="mb-3">
        <label for="habLinks" class="form-label">Habilitar links</label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="habLinks">
        </div>
    </div>
    <div class="mb-3">
        <label for="tempLink" class="form-label">Tempo de expiração dos links</label>
        <input type="number" class="form-control" id="tempLink" placeholder="Digite o tempo de expiração">
    </div>
    <div class="mb-3">
        <label for="tempForm" class="form-label">Tempo Limite de Resposta dos Formulários</label>
        <input type="number" class="form-control" id="tempForm" placeholder="Digite o tempo limite de resposta">
    </div>
    <div class="mb-3">
        <label for="notificResp" class="form-label">Notificar responsáveis</label>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="notificResp">
        </div>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
    <button type="button" class="btn btn-danger">Cancelar</button>
</form>