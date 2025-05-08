<?php

use App\Core\Auth;

include __DIR__ . '/../partials/messages.php' ?>


<div class="container mt-5">
    <h1 class="mb-4 text-center">Lista de Productos</h1>

    <div class="row g-4">
        <?php foreach ($productos as $producto): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                        class="card-img-top"
                        alt="Imagen de <?= htmlspecialchars($producto->nombre) ?>"
                        style="width: 100%; height: auto; object-fit: cover;">

                    <div class="card-body text-center">
                        <h5 class="card-title mb-2"><?= htmlspecialchars($producto->nombre) ?></h5>
                        <p class="text-muted mb-0"><?= number_format($producto->precio, 2) ?> €</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
