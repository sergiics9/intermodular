<?php

use App\Core\Auth;
?>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= htmlspecialchars($categoria->nombre) ?></h1>
        <a href="<?= BASE_URL ?>/categorias/index.php" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver a categorías
        </a>
    </div>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <?php if (empty($productos)): ?>
        <div class="alert alert-info">
            No hay productos en esta categoría.
        </div>

        <?php if (Auth::check() && Auth::role() == 1): ?>
            <div class="mt-3">
                <a href="<?= BASE_URL ?>/productos/create.php" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Añadir producto
                </a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($productos as $producto): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($producto->nombre) ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($producto->nombre) ?></h5>
                            <p class="card-text text-primary fw-bold"><?= number_format($producto->precio, 2) ?>€</p>
                            <p class="card-text text-truncate"><?= htmlspecialchars($producto->descripcion) ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="btn btn-outline-primary w-100">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
