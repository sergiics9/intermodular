<?php

use App\Core\Auth;
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>¡Pedido Confirmado!</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="display-1 text-success mb-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h4>Gracias por tu compra</h4>
                        <p class="lead">Tu pedido ha sido procesado correctamente.</p>
                    </div>

                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>Detalles del pedido</h5>
                        <p><strong>Número de pedido:</strong> #<?= $pedido->id ?></p>
                        <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido->Fecha)) ?></p>
                        <p><strong>Total:</strong> <?= number_format($pedido->Total, 2) ?> €</p>
                    </div>

                    <div class="mb-4">
                        <h5>Información de envío</h5>
                        <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido->Nombre) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($pedido->Email) ?></p>
                        <p><strong>Dirección:</strong> <?= htmlspecialchars($pedido->Direccion) ?></p>
                        <p><strong>Teléfono:</strong> <?= htmlspecialchars($pedido->Telefono) ?></p>
                    </div>

                    <div class="mb-4">
                        <h5>Resumen de productos</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Talla</th>
                                        <th>Cantidad</th>
                                        <th class="text-end">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedido->detalles()->get() as $detalle): ?>
                                        <?php $producto = $detalle->producto(); ?>
                                        <tr>
                                            <td>
                                                <?php if ($producto): ?>
                                                    <?= htmlspecialchars($producto->nombre) ?>
                                                <?php else: ?>
                                                    Producto no disponible
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($detalle->talla) ?></td>
                                            <td><?= $detalle->Cantidad ?></td>
                                            <td class="text-end"><?= number_format($detalle->Precio * $detalle->Cantidad, 2) ?> €</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th class="text-end"><?= number_format($pedido->Total, 2) ?> €</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-success">
                        <p class="mb-0"><i class="fas fa-envelope me-2"></i>Hemos enviado un correo electrónico con los detalles de tu compra a <strong><?= htmlspecialchars($pedido->Email) ?></strong>.</p>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
                        </a>
                        <?php if (Auth::check()): ?>
                            <a href="<?= BASE_URL ?>/pedidos/index.php" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>Ver mis pedidos
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
