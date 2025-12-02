<h3 class="mb-4 d-flex align-center">
    Olá, <?= session()->get('usuario')['name'] ?>!
    <span class="fs-4 mx-2">
        👋
    </span>
</h3>

<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">

    <div class="col">
        <div class="card text-success">
            <div class="card-body">
                <h3 class="card-title">
                    <i class="bi bi-chat-quote-fill me-1"></i>
                    <?= $formularios['respondidos'] ?>
                </h3>
                <p class="card-text">Formulários respondidos.</p>
                <a href="<?= base_url('formularios') ?>" class="btn btn-light">Ver detalhes...</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <i class="bi bi-file-bar-graph-fill me-1"></i>
                    <?= $formularios['ativos'] ?>
                </h3>
                <p class="card-text">Formulários ativos.</p>
                <a href="<?= base_url('formularios') ?>" class="btn btn-light">Ver detalhes...</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card text-warning">
            <div class="card-body">
                <h3 class="card-title">
                    <i class="bi bi-clipboard2-check-fill me-1"></i>
                    <?= $formularios['concluidos'] ?>
                </h3>
                <p class="card-text">Formulários concluídos.</p>
                <a href="<?= base_url('formularios') ?>" class="btn btn-light">Ver detalhes...</a>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row mt-4">
    <h4 class="mb-4 d-flex align-center">
        Notificações
        <span class="fs-5 mx-2">
            🔔
        </span>
    </h4>
    <div class="col">

        <?php if (!empty($notificacoes)) { ?>
            <?php foreach ($notificacoes as $notificacao) { ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $notificacao['titulo'] ?></h5>
                        <p class="card-text"><?= $notificacao['corpo'] ?></p>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">Nenhuma notificação por enquanto!</p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>