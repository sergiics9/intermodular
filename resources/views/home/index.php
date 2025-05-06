<div class="container mt-4">
    <div class="jumbotron">
        <h1>Bienvenido a nuestra Tienda Online</h1>
        <p class="lead">Descubre nuestra colección de productos</p>
    </div>

    <h2 class="mt-5 mb-4">Productos Destacados</h2>

    <div class="row">
        <?php foreach ($productosDestacados as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto->nombre) ?></h5>
                        <p class="card-text"><?= number_format($producto->precio, 2) ?>€</p>

                        <div class="size-options">
                            <?php foreach ($producto->tallasDisponibles() as $talla): ?>
                                <span class="size-option"><?= htmlspecialchars($talla) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary add-to-cart" disabled>Añadir al carrito</button>
                        <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="btn btn-outline-secondary">Ver detalles</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="mt-5 mb-4">Categorías</h2>

    <div class="row">
        <?php foreach ($categorias as $categoria): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($categoria->nombre) ?></h5>
                        <a href="<?= BASE_URL ?>/productos/index.php?categoria=<?= $categoria->id ?>" class="btn btn-outline-primary">Ver productos</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
