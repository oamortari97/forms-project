<div class="d-flex justify-content-between mb-3">
    <h3 class="mb-4">
        <?= $formulario['name'] ?>
        <span class="fs-4 mx-2">
            📃
        </span>
    </h3>

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
</div>

<div class="container mt-4">
    <div class="accordion" id="accordionPanelsStayOpenExample">
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