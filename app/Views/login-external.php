<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Identifique-se antes de responder</h5>
                </div>
                <div class="card-body">
                    <form id="loginForm" data-form-id="<?= $formulario ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="username" name="usuario" placeholder="Digite seu CPF" required>
                        </div>

                        <div class="d-flex justify-content-center mt-2">
                            <button type="submit" class="btn btn-outline-success">Continuar <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="response"></div>
        </div>
    </div>

</div>