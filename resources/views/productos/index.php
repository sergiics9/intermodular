<?php

use App\Core\Auth; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Lista de Productos</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <div class="row g-4">
        <?php foreach ($productos as $producto): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="text-decoration-none">
                        <div class="card-img-container">
                            <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                                class="card-img-top"
                                alt="Imagen de <?= htmlspecialchars($producto->nombre) ?>"
                                style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                    </a>

                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">
                            <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($producto->nombre) ?>
                            </a>
                        </h5>
                        <p class="text-primary fw-bold mb-3"><?= number_format($producto->precio, 2) ?> €</p>

                        <div class="d-grid">
                            <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="btn btn-outline-primary">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
