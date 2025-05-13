<?php

use App\Core\Auth;
use App\Core\DB;
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles del Pedido #<?= $pedido->id ?></h1>
        <a href="<?= BASE_URL ?>/pedidos/index.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a mis pedidos
        </a>
    </div>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <div class="row">
        <!-- Información del pedido -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1"><strong>Número de pedido:</strong> #<?= $pedido->id ?></p>
                        <p class="mb-1"><strong>Fecha:</strong> <?= $pedido->Fecha ? date('d/m/Y H:i', strtotime($pedido->Fecha)) : 'N/A' ?></p>
                        <p class="mb-1"><strong>Estado:</strong> <span class="badge bg-success">Completado</span></p>
                        <p class="mb-0"><strong>Total:</strong> <span class="fw-bold"><?= number_format($pedido->Total, 2) ?> €</span></p>
                    </div>

                    <hr>

                    <div>
                        <h6 class="mb-2">Datos de envío:</h6>
                        <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($pedido->Nombre) ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($pedido->Email) ?></p>
                        <p class="mb-1"><strong>Teléfono:</strong> <?= htmlspecialchars($pedido->Telefono) ?></p>
                        <p class="mb-0"><strong>Dirección:</strong> <?= htmlspecialchars($pedido->Direccion) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos del pedido -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Productos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Talla</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $detalles = DB::selectAssoc("SELECT dp.*, p.nombre, p.id as producto_id 
                                                            FROM detalles_pedido dp 
                                                            LEFT JOIN productos p ON dp.ProductoID = p.id 
                                                            WHERE dp.PedidoID = ?", [$pedido->id]);

                                foreach ($detalles as $detalle):
                                ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (isset($detalle['producto_id']) && $detalle['producto_id']): ?>
                                                    <img src="<?= BASE_URL ?>/images/<?= $detalle['producto_id'] ?>.webp"
                                                        alt="<?= htmlspecialchars($detalle['nombre'] ?? 'Producto') ?>"
                                                        class="img-thumbnail me-2"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $detalle['producto_id'] ?>" class="text-decoration-none">
                                                            <?= htmlspecialchars($detalle['nombre'] ?? 'Producto') ?>
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">Producto no disponible</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($detalle['talla'] ?? 'N/A') ?></td>
                                        <td><?= number_format($detalle['Precio'], 2) ?> €</td>
                                        <td><?= $detalle['Cantidad'] ?></td>
                                        <td class="fw-bold"><?= number_format($detalle['Precio'] * $detalle['Cantidad'], 2) ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Total:</td>
                                    <td class="fw-bold fs-5"><?= number_format($pedido->Total, 2) ?> €</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Acciones adicionales -->
            <div class="d-flex justify-content-between mt-4">
                <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
                </a>

                <?php if (Auth::user()['role'] == 1): ?>
                    <div>
                        <button class="btn btn-outline-success me-2" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Imprimir
                        </button>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-file-pdf me-2"></i>Generar PDF
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        header,
        footer,
        .btn,
        nav {
            display: none !important;
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
        }

        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }

        .card-header {
            background-color: #f8f9fa !important;
            color: #000 !important;
        }

        .badge {
            border: 1px solid #28a745 !important;
            color: #28a745 !important;
            background-color: transparent !important;
        }
    }
</style>
