$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#summaryBtn').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();

        $('#defaultModalLabel').text('Resumo do formulário');

        var formId = $(this).data('form-id');

        $.ajax({
            url: `${baseUrl}formularios/resumo`,
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

    $(document).on('click', '.responseBtn', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();

        $('#defaultModalLabel').text('Detalhes do formulário');

        var responseId = $(this).data('response-id');

        $.ajax({
            url: `${baseUrl}formularios/respostas/detalhe`,
            type: 'POST',
            data: { resposta_id: responseId},
            success: function (response) {
                $('#modalContent').html(response);
            },
            error: function (xhr, status, error) {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });


});
