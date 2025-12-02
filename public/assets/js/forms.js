$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#addFormBtn').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();
        $('#defaultModalLabel').text('Novo formulário');
        $('#modalContent').load(`${baseUrl}/formularios/novo`, function (response, status, xhr) {
            if (status == "error") {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.editFormBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Editar formulário');

            var formId = $(this).data('form-id');

            $.ajax({
                url: `${baseUrl}formularios/editar`,
                type: 'POST',
                data: { form_id: formId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function (xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.deleteFormBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Excluir formulário');

            var formId = $(this).data('form-id');

            $.ajax({
                url: `${baseUrl}formularios/apagar`,
                type: 'POST',
                data: { form_id: formId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function (xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.postFormBtn', function () {
            let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
            myModal.show();

            $('#defaultModalLabel').text('Publicar formulário');

            var formId = $(this).data('form-id');

            $.ajax({
                url: `${baseUrl}formularios/publicar`,
                type: 'POST',
                data: { form_id: formId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function (xhr, status, error) {
                    $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
                }
            });
        });
    });
});

