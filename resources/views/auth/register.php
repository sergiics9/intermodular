<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear Cuenta</h4>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/auth/register.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de perfil (opcional)</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?= htmlspecialchars(session()->getFlash('old')['nombre'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= htmlspecialchars(session()->getFlash('old')['email'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                value="<?= htmlspecialchars(session()->getFlash('old')['telefono'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un carácter especial.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms"
                                <?= isset(session()->getFlash('old')['terms']) ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">¿Ya tienes una cuenta? <a href="<?= BASE_URL ?>/auth/show-login.php">Iniciar Sesión</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
