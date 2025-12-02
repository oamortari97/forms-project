<form method="post" action="<?= base_url('externo-data') ?>">
    <div class="row mb-3">
        <div class="col">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="nome" placeholder="Digite o nome" required>
        </div>
        <div class="col">
            <label for="surname" class="form-label">Sobrenome</label>
            <input type="text" class="form-control" id="surname" name="sobrenome" placeholder="Digite o sobrenome" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">CPF</label>
        <input type="text" class="form-control" id="username" name="usuario" placeholder="Digite o CPF" required>
    </div>

    <input type="hidden" name="form_id" value="<?= $formulario ?>">

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar e inserir
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#username').on('input', function() {
            var value = $(this).val();
            var numericValue = value.replace(/\D/g, '');
            $(this).val(numericValue);
        });
    });
</script>