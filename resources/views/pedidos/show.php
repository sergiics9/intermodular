<div class="container">
    <h1 class="mb-4">Detalles del Pedido #<?= $pedido->PedidoID ?></h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Información del Pedido</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($pedido->Fecha)) ?></p>
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido->Nombre) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($pedido->Email) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Dirección:</strong> <?= htmlspecialchars($pedido->Direccion) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($pedido->Telefono) ?></p>
                    <p><strong>Total:</strong> €<?= number_format($pedido->Total, 2) ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Productos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Talla</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido->detalles()->get() as $detalle): ?>
                            <?php $producto = $detalle->producto(); ?>
                            <tr>
                                <td>
                                    <?php if ($producto): ?>
                                        <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>">
                                            <?= htmlspecialchars($producto->nombre) ?>
                                        </a>
                                    <?php else: ?>
                                        Producto no disponible
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($detalle->talla ?? 'N/A') ?></td>
                                <td>€<?= number_format($detalle->Precio, 2) ?></td>
                                <td><?= $detalle->Cantidad ?></td>
                                <td>€<?= number_format($detalle->Precio * $detalle->Cantidad, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>€<?= number_format($pedido->Total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= BASE_URL ?>/pedidos/index.php" class="btn btn-secondary">Volver a pedidos</a>
    </div>
</div>
