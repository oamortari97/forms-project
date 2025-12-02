<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: .5rem;
        box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
    }
</style>

<div class="container login-container">
    <div class="login-card bg-white">
        <h2 class="text-center mb-4">Entrar</h2>
        <form>
            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="username" placeholder="Digite seu nome de usuário" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
        </form>
    </div>
</div>