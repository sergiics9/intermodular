<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Contacto</h4>
                </div>
                <div class="card-body">
                    <p class="lead mb-4">¿Tienes alguna pregunta o comentario? Completa el formulario a continuación y nos pondremos en contacto contigo lo antes posible.</p>

                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/contacto/store.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                                id="nombre" name="nombre" value="<?= htmlspecialchars(session()->getFlash('old')['nombre'] ?? '') ?>" required>
                            <?php if (isset($errors['nombre'])): ?>
                                <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                id="email" name="email" value="<?= htmlspecialchars(session()->getFlash('old')['email'] ?? '') ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <textarea class="form-control <?= isset($errors['mensaje']) ? 'is-invalid' : '' ?>"
                                id="mensaje" name="mensaje" rows="5" required><?= htmlspecialchars(session()->getFlash('old')['mensaje'] ?? '') ?></textarea>
                            <?php if (isset($errors['mensaje'])): ?>
                                <div class="invalid-feedback"><?= $errors['mensaje'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Información de Contacto</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt me-2"></i>Dirección</h5>
                            <p>Calle Principal 123<br>28001 Madrid, España</p>

                            <h5><i class="fas fa-phone me-2"></i>Teléfono</h5>
                            <p>+34 91 123 45 67</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-envelope me-2"></i>Email</h5>
                            <p>info@tiendaonline.com</p>

                            <h5><i class="fas fa-clock me-2"></i>Horario</h5>
                            <p>Lunes a Viernes: 9:00 - 18:00<br>Sábados: 10:00 - 14:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
