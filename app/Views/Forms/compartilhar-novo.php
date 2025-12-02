<form method="post" action="<?= base_url('externo-data') ?>">
    <div class="mb-3">
        <label for="user" class="form-label">Selecionar usuário externo</label>

        <select class="form-select select-js" id="user" name="usuario">
            <option selected disabled value="">Selecionar usuário</option>

            <?php foreach ($acessos as $acesso) { ?>
                <option value="<?= $acesso['username'] ?>"><?= $acesso['username'] . (empty($acesso['name']) ? ''  : ' (' . $acesso['name'] . ' ' . $acesso['surname'] . ')')  ?></option>
            <?php } ?>

        </select>

    </div>
    <div class="d-flex justify-content-end">
        <div class="btn btn-outline-primary mx-2" id="newExternalBtn" data-form-id="<?= $formulario['id'] ?>">
            <i class="bi bi-plus-circle"></i> Adicionar Usuário Externo
        </div>

        <input type="hidden" name="form_id" value="<?= $formulario['id'] ?>">

        <button type="submit" class="btn btn-outline-success">
            <i class="bi bi-floppy"></i> Salvar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {

        let baseUrl = $('#base-url').data('base-url');
        $('select').each(function() {
            new SlimSelect({
                select: this,
            });
        });

        $('#newExternalBtn').on('click', function() {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));

            $('#defaultModalLabel').text('Novo usuário externo');

            var formId = $(this).data('form-id');

            $.ajax({
                url: `${baseUrl}/externo`,
                type: 'POST',
                data: {
                    form_id: formId
                },
                success: function(response) {
                    $('#modalContent').html(response);
                },
                error: function(xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });

        });

    });
</script>