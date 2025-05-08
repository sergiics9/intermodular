<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/auth/login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars(session()->getFlash('old')['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">¿No tienes una cuenta? <a href="<?= BASE_URL ?>/auth/show-register.php">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
