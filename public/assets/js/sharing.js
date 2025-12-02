$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#addShareBtn').on('click', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();

        $('#defaultModalLabel').text('Compartilhar');

        var formId = $(this).data('form-id');

        $.ajax({
            url: `${baseUrl}formularios/compartilhar-form`,
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

    $('.copyShareBtn').on('click', function () {
        var shareHash = $(this).data('share-hash');
        var accessLink = `${baseUrl}/responder/autenticado/${shareHash}`

        var $tempInput = $('<input>').val(accessLink).appendTo('body').select();
        document.execCommand('copy');
        $tempInput.remove();
        createSuccessAlert('Link copiado para a área de transferência.');
    });

    function createSuccessAlert(msg) {
        const alertHtml = `
        <div class="main-alert" id="alert-display">
            <div class="alert-icon alert-success">
                <span class="material-symbols-outlined">check</span>
            </div>
            <div class="alert-msg">${msg}</div>
            <div class="alert-close" id="close-alert">
                <span class="material-symbols-outlined">close</span>
            </div>
        </div>`;

        $('body').append(alertHtml);

        displayAlerts();
    }

    function displayAlerts() {
        let $alertDisplay = $('#alert-display');

        if ($alertDisplay.length) {
            $('#close-alert').on('click', function () {
                closeAlert();
            });

            setTimeout(function () {
                closeAlert();
            }, 4000);
        }
    }

    function closeAlert() {
        $('#alert-display').remove();
    }

    $(document).on('click', '.deleteShareBtn', function () {
        let myModal = new bootstrap.Modal(document.getElementById('defaultModal'));
        myModal.show();

        $('#defaultModalLabel').text('Excluir compartilhamento');

        var shareId = $(this).data('share-id');

        $.ajax({
            url: `${baseUrl}formularios/compartilhar-apagar`,
            type: 'POST',
            data: { compartilha_id: shareId },
            success: function (response) {
                $('#modalContent').html(response);
            },
            error: function (xhr, status, error) {
                $('#modalContent').html('<p>Houve um erro ao carregar a página externa.</p>');
            }
        });
    });

    $('#copyButton').on('click', function () {
        var $urlInput = $('#urlInput');
        $urlInput.select();
        $urlInput[0].setSelectionRange(0, 99999);

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'URL copiada para a área de transferência!' : 'Falha ao copiar a URL.';
            createSuccessAlert('Link copiado para a área de transferência.');
        } catch (err) {
            console.error('Erro ao copiar: ', err);
            alert('Erro ao copiar a URL.');
        }
    });
});