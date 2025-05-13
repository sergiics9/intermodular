<?php

use App\Core\Auth;
?>

<div class="container mt-5">
    <h1 class="mb-4">Tu Carrito de Compra</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>
    <?php include __DIR__ . '/../partials/errors.php'; ?>

    <?php if (empty($productos)): ?>
        <div class="alert alert-info">
            <p>Tu carrito está vacío.</p>
            <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-primary mt-3">Continuar comprando</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Talla</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $index => $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= BASE_URL ?>/images/<?= $item['producto']->id ?>.webp"
                                                alt="<?= htmlspecialchars($item['producto']->nombre) ?>"
                                                class="img-thumbnail me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($item['producto']->nombre) ?></h6>
                                                <small class="text-muted">ID: <?= $item['producto']->id ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($item['talla']) ?></td>
                                    <td><?= number_format($item['producto']->precio, 2) ?> €</td>
                                    <td>
                                        <form action="<?= BASE_URL ?>/carrito/update.php" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>"
                                                min="1" max="10" class="form-control form-control-sm"
                                                style="width: 60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="fw-bold"><?= number_format($item['subtotal'], 2) ?> €</td>
                                    <td>
                                        <form action="<?= BASE_URL ?>/carrito/remove.php" method="post">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total:</td>
                                <td class="fw-bold fs-5"><?= number_format($total, 2) ?> €</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Seguir comprando
                </a>
                <a href="<?= BASE_URL ?>/carrito/clear.php" class="btn btn-outline-danger ms-2"
                    onclick="return confirm('¿Estás seguro de vaciar el carrito?')">
                    <i class="fas fa-trash me-2"></i>Vaciar carrito
                </a>
            </div>
            <a href="<?= BASE_URL ?>/carrito/checkout.php" class="btn btn-primary">
                <i class="fas fa-shopping-cart me-2"></i>Finalizar compra
            </a>
        </div>
    <?php endif; ?>
</div>
