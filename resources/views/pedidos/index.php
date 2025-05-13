<?php

use App\Core\Auth;
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Auth::user()['role'] == 1 ? 'Todos los Pedidos' : 'Mis Pedidos' ?></h1>
        <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-outline-primary">
            <i class="fas fa-shopping-bag me-2"></i>Seguir comprando
        </a>
    </div>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info">
            <p class="mb-0">No tienes pedidos realizados todavía.</p>
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>Explorar productos
            </a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nº Pedido</th>
                                <th>Fecha</th>
                                <?php if (Auth::user()['role'] == 1): ?>
                                    <th>Cliente</th>
                                    <th>Email</th>
                                <?php endif; ?>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>#<?= $pedido->id ?></td>
                                    <td>
                                        <?php
                                        if (isset($pedido->Fecha) && !empty($pedido->Fecha) && $pedido->Fecha != '0000-00-00 00:00:00') {
                                            echo date('d/m/Y H:i', strtotime($pedido->Fecha));
                                        } else {
                                            echo date('d/m/Y H:i');
                                        }
                                        ?>
                                    </td>
                                    <?php if (Auth::user()['role'] == 1): ?>
                                        <td><?= htmlspecialchars($pedido->Nombre) ?></td>
                                        <td><?= htmlspecialchars($pedido->Email) ?></td>
                                    <?php endif; ?>
                                    <td class="fw-bold"><?= number_format($pedido->Total, 2) ?> €</td>
                                    <td>
                                        <span class="badge bg-success">Completado</span>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/pedidos/show.php?id=<?= $pedido->id ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
