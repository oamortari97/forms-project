<div class="form-container mx-auto">

    <div class="d-flex justify-content-between">
        <h3><?= htmlspecialchars($formulario['name']) ?> <i class="bi bi-file-earmark text-muted"></i></h3>
        <div class="alert alert-primary" role="alert">
            <strong>Respondendo como:</strong> <?= htmlspecialchars($usuario) ?>
        </div>
    </div>

    <p class="mb-3 p-0"><?= $formulario['description'] ?></p>


    <form id="responseForm" method="post" data-form-id="<?= htmlspecialchars($formulario['id']) ?>" data-user="<?= htmlspecialchars($formulario['answer_by']) ?>">
        <?php foreach ($formulario['questions'] as $question) { ?>
            <div class="row mb-4">
                <div class="col">
                    <label for="<?= htmlspecialchars($question['id']) ?>" class="form-label fs-5"><?= htmlspecialchars($question['text']) ?></label>
                    <?php if ($question['type'] === 'text') { ?>
                        <div class="mt-2">
                            <textarea class="form-control" name="question_<?= htmlspecialchars($question['id']) ?>_<?= $question['type'] ?>" placeholder="Resposta em texto..." rows="4"></textarea>
                        </div>
                    <?php } else { ?>
                        <?php foreach ($question['options'] as $index => $option) { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="<?= $question['type'] === 'truefalse' ? 'radio' : ($question['type'] === 'single' ? 'radio' : 'checkbox') ?>" name="question_<?= htmlspecialchars($question['id']) ?>_<?= $question['type'] ?>[]" id="<?= htmlspecialchars($question['id']) ?>-<?= $index + 1 ?>" value="<?= htmlspecialchars($option['id']) ?>">
                                <label class="form-check-label" for="<?= htmlspecialchars($question['id']) ?>-<?= $index + 1 ?>">
                                    <?= htmlspecialchars($option['text']) ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="mt-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-lg btn-outline-success">Enviar formulário</button>
        </div>
    </form>
</div>