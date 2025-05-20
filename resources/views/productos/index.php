<?php
$title = 'Productos';
?>

<div class="container mt-4">
    <h1 class="mb-4">Productos</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <!-- Dropdown de ordenación -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="sort-dropdown dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sort-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-sort"></i> Ordenar por: <span id="current-sort-text">
                    <?php
                    switch ($sortBy ?? 'newest') {
                        case 'price_asc':
                            echo 'Precio: menor a mayor';
                            break;
                        case 'price_desc':
                            echo 'Precio: mayor a menor';
                            break;
                        case 'name_asc':
                            echo 'Nombre: A-Z';
                            break;
                        case 'name_desc':
                            echo 'Nombre: Z-A';
                            break;
                        case 'newest':
                        default:
                            echo 'Más recientes';
                            break;
                    }
                    ?>
                </span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="sort-dropdown">
                <li><a class="dropdown-item sort-option <?= ($sortBy ?? 'newest') === 'newest' ? 'active' : '' ?>" href="#" data-sort="newest">Más recientes</a></li>
                <li><a class="dropdown-item sort-option <?= ($sortBy ?? '') === 'price_asc' ? 'active' : '' ?>" href="#" data-sort="price_asc">Precio: menor a mayor</a></li>
                <li><a class="dropdown-item sort-option <?= ($sortBy ?? '') === 'price_desc' ? 'active' : '' ?>" href="#" data-sort="price_desc">Precio: mayor a menor</a></li>
                <li><a class="dropdown-item sort-option <?= ($sortBy ?? '') === 'name_asc' ? 'active' : '' ?>" href="#" data-sort="name_asc">Nombre: A-Z</a></li>
                <li><a class="dropdown-item sort-option <?= ($sortBy ?? '') === 'name_desc' ? 'active' : '' ?>" href="#" data-sort="name_desc">Nombre: Z-A</a></li>
            </ul>
        </div>
    </div>

    <?php if (empty($productos)): ?>
        <div class="alert alert-info">
            No hay productos disponibles.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="products-container">
            <?php foreach ($productos as $producto): ?>
                <div class="col product-item" data-price="<?= $producto->precio ?>" data-name="<?= htmlspecialchars($producto->nombre) ?>" data-id="<?= $producto->id ?>">
                    <div class="card h-100">
                        <div class="card-img-container">
                            <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($producto->nombre) ?>"
                                onerror="this.src='<?= BASE_URL ?>/images/placeholder.svg'">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($producto->nombre) ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($producto->descripcion, 0, 100)) ?>...</p>
                            <p class="card-text"><strong>Precio:</strong> €<?= number_format($producto->precio, 2) ?></p>
                            <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="btn btn-primary">Ver detalles</a>

                            <?php if (App\Core\Auth::check() && App\Core\Auth::role() === 1): ?>
                                <div class="mt-2">
                                    <a href="<?= BASE_URL ?>/productos/edit.php?id=<?= $producto->id ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="<?= BASE_URL ?>/productos/destroy.php" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?= $producto->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Incluir los estilos y scripts del ordenador de productos -->
<link rel="stylesheet" href="<?= BASE_URL ?>/css/product-sorter.css">
<script src="<?= BASE_URL ?>/js/product-sorter.js"></script>
