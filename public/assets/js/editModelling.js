$(document).ready(function () {
    let baseUrl = $('#base-url').data('base-url');

    let itemCount = $('.newQuestionItem').length;
    let removedIds = [];

    // Evento para adicionar um novo item ao accordion
    $('.newQuestionBtn').on('click', function (e) {
        e.preventDefault();
        const type = $(this).data('type');
        addAccordionItem(type);
    });

    // Função para adicionar um novo item ao accordion
    function addAccordionItem(type) {
        const accordion = $('#accordionPanelsStayOpenExample');
        let newItemId = itemCount + 1;

        if (removedIds.length > 0) {
            newItemId = removedIds.pop();
        } else {
            itemCount++;
        }

        // Mapeia o tipo para uma string descritiva
        const typeLabel = {
            'text': 'Texto',
            'radio': 'Escolha múltipla',
            'single': 'Escolha única',
            'truefalse': 'Verdadeiro/Falso'
        }[type];

        const newItem = `
            <div class="accordion-item newQuestionItem" id="item${newItemId}">
                <h2 class="accordion-header d-flex align-items-center" id="heading${newItemId}">
                    <button class="newQuestionTitle accordion-button d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${newItemId}" aria-expanded="true" aria-controls="collapse${newItemId}" data-question-type="${type}">
                        <span>Questão ${newItemId}: ${typeLabel}</span>
                        <span class="btn btn-outline-danger remove-btn ms-2" style="position: absolute; right: 4rem" onclick="removeAccordionItem(${newItemId})"><i class="bi bi-trash3"></i></span>
                    </button>
                </h2>
                <div id="collapse${newItemId}" class="accordion-collapse collapse" aria-labelledby="heading${newItemId}">
                    <div class="accordion-body">
                        <label for="question${newItemId}" class="form-label">Label da pergunta</label>
                        <input type="text" name="question${newItemId}" class="form-control" id="question${newItemId}" placeholder="Digite o label da pergunta...">

                        <div class="my-3">
                            ${type === 'text' ? 'Resposta <button type="button" class="btn btn-sm btn-outline-primary mx-1" style="padding: 0rem 0.4rem" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Exibe uma área de texto para que o usuário escreva uma resposta completa. Não é possível adicionar opções adicionais."><i class="bi bi-info"></i></button>' : `Respostas ${type === 'truefalse' ? '<button type="button" class="btn btn-sm btn-outline-primary mx-1" style="padding: 0rem 0.4rem" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Selecione a opção que é verdadeira."><i class="bi bi-info"></i></button>' : ''}`}
                        </div>

                        <div id="responses${newItemId}">
                            ${type === 'text' ? '<div class="mt-2"><textarea class="form-control" placeholder="Resposta em texto..." rows="4" readonly></textarea></div>' : ''}
                        </div>

                        ${type !== 'text' ? `
                            <div class="input-group mt-2">
                                <input type="text" id="responseLabel${newItemId}" class="form-control" placeholder="Digite o label da opção...">
                                <button class="btn btn-outline-success" type="button" onclick="addResponse(${newItemId}, '${type}')">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;

        accordion.append(newItem);
        initializeTooltips();

        // Fecha todos os itens do accordion, exceto o mais recente
        $('.accordion-collapse').collapse('hide');
        $(`#collapse${newItemId}`).collapse('show');

        // Atualiza itemCount
        itemCount = Math.max(itemCount, newItemId);
    }

    // Função para adicionar uma nova resposta
    window.addResponse = function (itemId, type) {
        if (type === 'text') return; // Não faz nada se o tipo for texto

        const responsesContainer = $(`#responses${itemId}`);
        const label = $(`#responseLabel${itemId}`).val();

        if (!label.trim()) {
            createErrorAlert('Por favor, insira o label da opção.');
            return;
        }

        let responseElement;

        if (type === 'radio' || type === 'single') {
            responseElement = $(`
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="option${itemId}" id="option${itemId}-${responsesContainer.children().length + 1}">
                    <label class="form-check-label" for="option${itemId}-${responsesContainer.children().length + 1}">
                        ${label}
                    </label>
                    <span class="btn btn-sm btn-outline-danger mx-1" style="padding: 0rem 0.4rem" onclick="removeResponse(this)">&times;</span>
                </div>
            `);
        } else if (type === 'truefalse') {
            const currentRadioCount = responsesContainer.find('input[type=radio]').length;
            const isChecked = currentRadioCount === 0;
            responseElement = $(`
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="truefalse${itemId}" id="truefalse${itemId}-${currentRadioCount + 1}" ${isChecked ? 'checked' : ''}>
                    <label class="form-check-label" for="truefalse${itemId}-${currentRadioCount + 1}">
                        ${label}
                    </label>
                    <span class="btn btn-sm btn-outline-danger mx-1" style="padding: 0rem 0.4rem" onclick="removeResponse(this)">&times;</span>
                </div>
            `);
        }

        responsesContainer.append(responseElement);
        $(`#responseLabel${itemId}`).val('');
    }

    // Função para remover um item do accordion
    window.removeAccordionItem = function (itemId) {
        $(`#item${itemId}`).remove();
        removedIds.push(itemId);

        // Após a remoção, atualiza o itemCount e abre o último item disponível
        itemCount = Math.max(...$('.newQuestionItem').map((_, el) => parseInt($(el).attr('id').replace('item', ''))).get());
        if (itemCount) {
            $('.accordion-collapse').collapse('hide');
            $(`#collapse${itemCount}`).collapse('show');
        }
    }

    // Função para remover uma opção de resposta
    window.removeResponse = function (element) {
        $(element).closest('.form-check, .input-group').remove();
    }

    function initializeTooltips() {
        $('[data-bs-toggle="tooltip"]').each(function () {
            new bootstrap.Tooltip(this);
        });
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

    $('#saveFormBtn').on('click', function (e) {
        let formId = $(this).data('form-id');

        e.preventDefault();
        saveForm(formId);
    });

    function saveForm(formId) {
        let questions = [];

        $('.newQuestionItem').each(function () {
            let itemId = $(this).attr('id').replace('item', '');
            let questionText = $(`#question${itemId}`).val();
            let questionType = $(this).find('.newQuestionTitle').data('question-type');
            let options = [];

            if (questionType !== 'Texto') {
                $(this).find('.form-check').each(function () {
                    let optionText = $(this).find('label').text().trim();
                    let isTrue = $(this).find('input').is(':checked');
                    options.push({ text: optionText, true: isTrue });
                });
            }

            questions.push({
                id: itemId,
                text: questionText,
                type: questionType.toLowerCase(),
                options: options
            });
        });

        $.ajax({
            url: `${baseUrl}/formularios/modelar-data`,
            type: 'POST',
            data: {
                form_id: formId,
                questoes: questions
            },
            success: function (response) {
                window.location.href = `${baseUrl}formularios`;
            },
            error: function (xhr) {
                createErrorAlert('Erro ao salvar o formulário.');
            }
        });
    }

    function initData() {
        const lastAccordionItem = $('.accordion-item').last();
        const lastCollapseId = lastAccordionItem.find('.accordion-collapse').attr('id');
        $(`#${lastCollapseId}`).collapse('show');
    }

    initializeTooltips();
    initData();
    displayAlerts();
});
