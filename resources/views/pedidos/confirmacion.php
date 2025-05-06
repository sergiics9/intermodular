<?php
// resources/views/pedidos/confirmacion.php
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">¡Pedido Confirmado!</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <p>Tu pedido ha sido procesado correctamente.</p>
                        <p>Hemos enviado un correo electrónico con los detalles de tu compra.</p>
                    </div>

                    <p>Gracias por tu compra. Recibirás una confirmación por correo electrónico con los detalles de tu pedido.</p>

                    <?php if (Auth::check()): ?>
                        <p>Puedes ver el estado de tu pedido en la sección <a href="<?= BASE_URL ?>/pedidos/index.php">Mis Pedidos</a>.</p>
                    <?php endif; ?>

                    <div class="mt-4">
                        <a href="<?= BASE_URL ?>/index.php" class="btn btn-primary">Volver a la tienda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
