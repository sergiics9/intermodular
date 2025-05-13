<?php

use App\Core\Auth; ?>

<div class="container">
    <h1 class="mb-4">
        <?= Auth::user()['role'] == 1 ? 'Todos los Pedidos' : 'Mis Pedidos' ?>
    </h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info">
            No hay pedidos para mostrar.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= $pedido->id ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido->Fecha)) ?></td>
                            <td><?= htmlspecialchars($pedido->Nombre) ?></td>
                            <td>€<?= number_format($pedido->Total, 2) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/pedidos/show.php?id=<?= $pedido->id ?>" class="btn btn-info btn-sm">Ver detalles</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
