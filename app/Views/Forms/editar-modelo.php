<?php

function questionTypesBr($type)
{
    $type = strtolower($type);

    $translate = [
        'text' => 'Texto',
        'radio' => 'Escolha múltipla',
        'single' => 'Escolha única',
        'truefalse' => 'Verdadeiro/Falso'
    ];

    return $translate[$type];
}

$inactive = ($formulario['posted'] == '1'  ? true : false);

if (isset($respostas['response_count']) && $respostas['response_count'] > 0) {
    $inactive = true;
}
?>

<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">
        <?= $formulario['name'] ?>
        <span class="fs-4 mx-2">
            📃
        </span>
    </h3>

    <?php if (!$inactive) { ?>
        <div class="dropdown d-flex justify-content-end mb-3">
            <button class="btn btn-outline-primary dropdown-toggle me-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-plus-circle"></i> Nova questão
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item newQuestionBtn" href="#" data-type="text">Texto</a></li>
                <li><a class="dropdown-item newQuestionBtn" href="#" data-type="radio">Múltipla escolha</a></li>
                <li><a class="dropdown-item newQuestionBtn" href="#" data-type="single">Escolha única</a></li>
                <li><a class="dropdown-item newQuestionBtn" href="#" data-type="truefalse">Verdadeiro/Falso</a></li>
            </ul>


            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                <i class="bi bi-floppy"></i> Salvar
            </button>
        </div>
    <?php } ?>
</div>
<?php if ($inactive) { ?>
    <div class="alert alert-primary" role="alert">
        <strong>Importante:</strong> Este formulário já foi publicado ou respondido. Alterações não estão permitidas.
    </div>
<?php } ?>

<div class="container mt-4">
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <?php
        $count = 1;
        foreach ($formulario['questions'] as $question) { ?>
            <div class="accordion-item newQuestionItem" id="item<?= $count ?>">
                <h2 class="accordion-header d-flex align-items-center" id="heading<?= $count ?>">
                    <button class="newQuestionTitle accordion-button d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $count ?>" aria-expanded="true" aria-controls="collapse<?= $count ?>" data-question-type="<?= htmlspecialchars($question['type']) ?>">
                        <span>Questão <?= $count ?>: <?= questionTypesBr($question['type']) ?></span>
                        <?php if (!$inactive) { ?>
                            <span class="btn btn-outline-danger remove-btn ms-2" style="position: absolute; right: 4rem" onclick="removeAccordionItem(<?= $count ?>)"><i class="bi bi-trash3"></i></span>
                        <?php } ?>
                    </button>
                </h2>
                <div id="collapse<?= $count ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $count ?>">
                    <div class="accordion-body">

                        <?php if (!$inactive) { ?>
                            <label for="question<?= $count ?>" class="form-label">Label da pergunta</label>
                            <input type="text" name="question<?= $count ?>" class="form-control" id="question<?= $count ?>" value="<?= htmlspecialchars($question['text']) ?>" placeholder="Digite o label da pergunta...">
                        <?php } else { ?>
                            <div class="fs-5"><?= htmlspecialchars($question['text']) ?></div>
                        <?php } ?>


                        <div class="my-3">
                            <?= $question['type'] === 'text' ? 'Resposta em texto' : 'Opções' ?>
                            <?= $question['type'] === 'text' ? '<button type="button" class="btn btn-sm btn-outline-primary mx-1" style="padding: 0rem 0.4rem" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Exibe uma área de texto para que o usuário escreva uma resposta completa."><i class="bi bi-info"></i></button>' : ($question['type'] === 'truefalse' ? '<button type="button" class="btn btn-sm btn-outline-primary mx-1" style="padding: 0rem 0.4rem" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="A opção verdadeira está selecionada."><i class="bi bi-info"></i></button>' : '') ?>
                        </div>

                        <div id="responses<?= $count ?>">
                            <?php if ($question['type'] === 'text') { ?>
                                <div class="mt-2">
                                    <textarea class="form-control" placeholder="Resposta em texto..." rows="4" readonly></textarea>
                                </div>
                            <?php } else { ?>
                                <?php foreach ($question['options'] as $index => $option) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" <?= $inactive ? 'disabled' : '' ?> type="<?= $question['type'] === 'truefalse' ? 'radio' : ($question['type'] === 'single' ? 'radio' : 'checkbox') ?>" name="<?= $question['type'] === 'truefalse' ? 'truefalse' . $count : 'option' . $count ?>" id="option<?= $count ?>-<?= $index + 1 ?>" <?= $option['true'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="option<?= $count ?>-<?= $index + 1 ?>">
                                            <?= $option['text'] ?>
                                        </label>

                                        <?php if (!$inactive) { ?>
                                            <span class="btn btn-sm btn-outline-danger mx-1" style="padding: 0rem 0.4rem" onclick="removeResponse(this)">&times;</span>
                                        <?php } ?>

                                    </div>
                                <?php } ?>

                                <?php if (!$inactive) { ?>
                                    <div class="input-group mt-2">
                                        <input type="text" id="responseLabel<?= $count ?>" class="form-control" placeholder="Digite o label da opção...">
                                        <button class="btn btn-outline-success" type="button" onclick="addResponse(<?= $count ?>, '<?= $question['type'] ?>')">
                                            <i class="bi bi-plus-circle"></i>
                                        </button>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $count++;
        } ?>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmationModalLbl">Salvar formulário</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-3">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div class="text-danger" style="font-size:2.5rem">
                        <div class="alert-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                    </div>
                    <div role="alert" aria-live="assertive" class="text-center">
                        <div class="mb-2"><strong>Tem certeza de que deseja salvar o formulário?</strong></div>
                        <div>Certifique-se de que todas as informações estão corretas.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-primary" id="saveFormBtn" data-form-id="<?= $formulario['id'] ?>">Salvar e fechar</button>
            </div>
        </div>
    </div>
</div>