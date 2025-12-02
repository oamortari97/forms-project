$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#username').on('input', function () {
        var value = $(this).val();
        var numericValue = value.replace(/\D/g, '');

        $(this).val(numericValue);
    });


    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        var username = $('#username').val();
        var formId = $(this).data('form-id');

        $.ajax({
            url: `${baseUrl}responder/validar`,
            type: 'POST',
            data: { usuario: username, form_id: formId },
            success: function (response) {
                window.location.href = `${baseUrl}responder/autenticado/${response}`;
            },
            error: function (xhr, status, error) {
                var jsonResponse = JSON.parse(xhr.responseText);
                $('#response').html('<div class="alert alert-danger">' + jsonResponse.return.data + '</div>');
            }
        });
    });

});