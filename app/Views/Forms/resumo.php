<div class="container mt-4">
    <?php foreach ($resumo as $question_id => $resumoItem) { ?>
        <div class="mb-4">
            <h4><?= htmlspecialchars($resumoItem['question_text']) ?></h4>
            <?php
            $maxCount = max(array_column($resumoItem['options'], 'option_count'));
            ?>
            <?php foreach ($resumoItem['options'] as $option_id => $opcao) { ?>
                <div class="d-flex flex-column mb-3">
                    <?php if (empty(trim($opcao['option_text']))) { ?>
                        <strong class="mb-1">Campo texto</strong>
                    <?php } else { ?>
                        <strong class="mb-1"><?= htmlspecialchars($opcao['option_text']) ?>:</strong>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?= ($maxCount > 0 ? ($opcao['option_count'] / $maxCount * 100) : 0) ?>%;" aria-valuenow="<?= $opcao['option_count'] ?>" aria-valuemin="0" aria-valuemax="<?= $maxCount ?>">
                                <span><?= htmlspecialchars($opcao['option_count']) ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>