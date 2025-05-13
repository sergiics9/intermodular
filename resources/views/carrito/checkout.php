<?php

use App\Core\Auth;
?>

<div class="container mt-5">
    <h1 class="mb-4">Finalizar Compra</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>
    <?php include __DIR__ . '/../partials/errors.php'; ?>

    <div class="row">
        <!-- Formulario de datos de envío -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Datos de Envío</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/carrito/process.php" method="post" id="checkout-form">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
                                id="nombre" name="nombre"
                                value="<?= htmlspecialchars(session()->getFlash('old')['nombre'] ?? ($usuario['nombre'] ?? '')) ?>"
                                required>
                            <?php if (isset($errors['nombre'])): ?>
                                <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                id="email" name="email"
                                value="<?= htmlspecialchars(session()->getFlash('old')['email'] ?? ($usuario['email'] ?? '')) ?>"
                                required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección de envío</label>
                            <textarea class="form-control <?= isset($errors['direccion']) ? 'is-invalid' : '' ?>"
                                id="direccion" name="direccion" rows="3" required><?= htmlspecialchars(session()->getFlash('old')['direccion'] ?? '') ?></textarea>
                            <?php if (isset($errors['direccion'])): ?>
                                <div class="invalid-feedback"><?= $errors['direccion'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control <?= isset($errors['telefono']) ? 'is-invalid' : '' ?>"
                                id="telefono" name="telefono"
                                value="<?= htmlspecialchars(session()->getFlash('old')['telefono'] ?? ($usuario['telefono'] ?? '')) ?>"
                                required>
                            <?php if (isset($errors['telefono'])): ?>
                                <div class="invalid-feedback"><?= $errors['telefono'] ?></div>
                            <?php endif; ?>
                            <div class="form-text">Formato: 9 dígitos sin espacios ni guiones</div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Método de pago</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" checked>
                                <label class="form-check-label" for="tarjeta">
                                    <i class="far fa-credit-card me-2"></i>Tarjeta de crédito/débito
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    <i class="fab fa-paypal me-2"></i>PayPal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia">
                                <label class="form-check-label" for="transferencia">
                                    <i class="fas fa-university me-2"></i>Transferencia bancaria
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Realizar pedido
                            </button>
                            <a href="<?= BASE_URL ?>/carrito/index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al carrito
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Resumen del pedido -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Resumen del pedido</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Cant.</th>
                                    <th class="text-end">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= BASE_URL ?>/images/<?= $item['producto']->id ?>.webp"
                                                    alt="<?= htmlspecialchars($item['producto']->nombre) ?>"
                                                    class="img-thumbnail me-2"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                <div class="small"><?= htmlspecialchars($item['producto']->nombre) ?></div>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($item['talla']) ?></td>
                                        <td><?= $item['cantidad'] ?></td>
                                        <td class="text-end"><?= number_format($item['subtotal'], 2) ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío:</span>
                        <span>Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                        <span>Total:</span>
                        <span><?= number_format($total, 2) ?> €</span>
                    </div>

                    <div class="alert alert-info mt-4 small">
                        <i class="fas fa-info-circle me-2"></i>
                        Al realizar el pedido, aceptas nuestros términos y condiciones y política de privacidad.
                    </div>
                </div>
            </div>

            <!-- Métodos de pago aceptados -->
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Métodos de pago aceptados</h6>
                    <div class="d-flex gap-3 mt-2">
                        <i class="fab fa-cc-visa fa-2x text-primary"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                        <i class="fab fa-cc-amex fa-2x text-info"></i>
                        <i class="fab fa-paypal fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
