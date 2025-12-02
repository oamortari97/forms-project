$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    $('#responseForm').on('submit', function (event) {
        event.preventDefault();

        if (!validateForm()) {
            createErrorAlert('Por favor, responda todas as questões.');
            return;
        }

        var formId = $(this).data('form-id');
        var userId = $(this).data('user');

        var formData = $(this).serializeArray();

        formData.push({ name: 'form_id', value: formId });
        formData.push({ name: 'user_id', value: userId });

        console.log(formData);

        var data = {};
        formData.forEach(function (item) {
            if (!data[item.name]) {
                data[item.name] = [];
            }
            data[item.name].push(item.value);
        });

        var serializedData = $.param(data, true);

        $.ajax({
            url: `${baseUrl}responder/responder-data`,
            type: 'POST',
            data: serializedData,
            success: function (response) {
                $('#load-view').html(`
                <div class="text-success mb-3">
                    <h2>
                        <i class="bi bi-check-circle"></i>
                        Obrigado!
                    </h2>
                </div>
                Sua resposta foi enviada com sucesso.<br>
                Sua opinião é muito importante para nós!
                `);

                const url = window.location.href;
                const urlObj = new URL(url);
                const pathParts = urlObj.pathname.split('/');

                if (pathParts[2] === 'responder' && pathParts[3] === 'autenticado') {
                    setTimeout(() => {
                        window.location.replace(document.referrer);
                    }, 5000);
                }

            },
            error: function (xhr, status, error) {
                createErrorAlert('Não foi possível salvar o formulário. Por favor, tente novamente.')
            }
        });
    });

    function validateForm() {
        let isValid = true;

        $('.is-invalid').removeClass('is-invalid');
        $('.form-group').removeClass('has-error');

        $('#responseForm textarea').each(function () {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            }
        });

        $('input[type="checkbox"]').each(function () {
            let name = $(this).attr('name');
            if ($(`input[name="${name}"]:checked`).length === 0) {
                $(`input[name="${name}"]`).closest('.form-group').addClass('has-error');
                isValid = false;
            }
        });

        $('input[type="radio"]').each(function () {
            let name = $(this).attr('name');
            if ($(`input[name="${name}"]:checked`).length === 0) {
                $(`input[name="${name}"]`).closest('.form-group').addClass('has-error');
                isValid = false;
            }
        });

        return isValid;
    }

    function createErrorAlert(msg) {
        const alertHtml = `
        <div class="main-alert" id="alert-display">
            <div class="alert-icon alert-danger">
                <span class="material-symbols-outlined">close</span>
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
});
