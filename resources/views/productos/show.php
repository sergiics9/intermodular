<?php

use App\Core\Auth;

$categoria = $producto->categoria();
$tallas = $producto->tallas()->get();
?>

<div class="container mt-5">
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-md-6 mb-4">
            <div class="product-image-container">
                <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                    class="img-fluid rounded shadow"
                    alt="<?= htmlspecialchars($producto->nombre) ?>"
                    style="width: 100%; max-height: 500px; object-fit: cover;">
            </div>
        </div>

        <!-- Detalles del producto -->
        <div class="col-md-6">
            <div class="product-details-flex" data-product-id="<?= $producto->id ?>">
                <h3 class="mb-3 fw-bold"><?= htmlspecialchars($producto->nombre) ?></h3>

                <?php if ($categoria): ?>
                    <div class="mb-3">
                        <span class="badge bg-secondary"><?= htmlspecialchars($categoria->nombre) ?></span>
                    </div>
                <?php endif; ?>

                <p class="fs-4 fw-bold text-primary mb-4"><?= number_format($producto->precio, 2) ?>€</p>

                <div class="mb-4">
                    <h5 class="mb-2">Descripción:</h5>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($producto->descripcion)) ?></p>
                </div>

                <?php if (!empty($tallas)): ?>
                    <form action="<?= BASE_URL ?>/carrito/add.php" method="post">
                        <input type="hidden" name="producto_id" value="<?= $producto->id ?>">
                        <input type="hidden" name="cantidad" value="1">

                        <div class="mb-4">
                            <h5 class="mb-2">Tallas disponibles:</h5>
                            <div class="size-options">
                                <?php foreach ($tallas as $talla): ?>
                                    <label class="size-option-label">
                                        <input type="radio" name="talla" value="<?= htmlspecialchars($talla->tallas) ?>" class="size-radio" required>
                                        <span class="size-option"><?= htmlspecialchars($talla->tallas) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-cart me-2"></i>Añadir al carrito
                            </button>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if (Auth::check() && Auth::role() == 1): ?>
                    <div class="mt-4 admin-actions">
                        <a href="<?= BASE_URL ?>/productos/edit.php?id=<?= $producto->id ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Eliminar
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Productos relacionados -->
    <?php if ($categoria && count($categoria->productos()->get()) > 1): ?>
        <div class="mt-5">
            <h3 class="mb-4">Productos relacionados</h3>
            <div class="row">
                <?php
                $productosRelacionados = $categoria->productos()->where('id', '!=', $producto->id)->limit(4)->get();
                foreach ($productosRelacionados as $productoRelacionado):
                ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= BASE_URL ?>/images/<?= $productoRelacionado->id ?>.webp"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($productoRelacionado->nombre) ?>"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($productoRelacionado->nombre) ?></h5>
                                <p class="card-text text-primary fw-bold"><?= number_format($productoRelacionado->precio, 2) ?>€</p>
                                <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $productoRelacionado->id ?>" class="btn btn-outline-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sección de comentarios -->
    <div class="mt-5">
        <h3 class="mb-4">Comentarios (<?= count($producto->comentarios()->get()) ?>)</h3>

        <?php if (Auth::check()): ?>
            <!-- Formulario para añadir comentarios -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="<?= BASE_URL ?>/comentarios/store.php" method="POST">
                        <input type="hidden" name="producto_id" value="<?= $producto->id ?>">
                        <div class="mb-3">
                            <label for="texto" class="form-label">Deja tu comentario</label>
                            <textarea class="form-control" id="texto" name="texto" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publicar comentario</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-4">
                <a href="<?= BASE_URL ?>/auth/show-login.php">Inicia sesión</a> para dejar un comentario.
            </div>
        <?php endif; ?>

        <!-- Lista de comentarios -->
        <?php
        $comentarios = $producto->comentarios()->get();
        if (empty($comentarios)):
        ?>
            <div class="alert alert-light">
                No hay comentarios todavía. ¡Sé el primero en comentar!
            </div>
        <?php else: ?>
            <?php foreach ($comentarios as $comentario): ?>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= htmlspecialchars($comentario->usuario()->nombre) ?></strong>
                            <small class="text-muted ms-2"><?= date('d/m/Y H:i', strtotime($comentario->fecha)) ?></small>
                        </div>
                        <?php if (Auth::check() && Auth::role() == 1): ?>
                            <form action="<?= BASE_URL ?>/comentarios/destroy.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $comentario->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este comentario?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?= nl2br(htmlspecialchars($comentario->texto)) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<?php if (Auth::check() && Auth::role() == 1): ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="<?= BASE_URL ?>/productos/destroy.php" method="POST">
                        <input type="hidden" name="id" value="<?= $producto->id ?>">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    /* Estilos para las opciones de talla con radio buttons */
    .size-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .size-option-label {
        position: relative;
        margin: 0;
        cursor: pointer;
    }

    .size-radio {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .size-option {
        display: inline-block;
        padding: 0.5rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .size-radio:checked+.size-option {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .size-radio:focus+.size-option {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .size-option:hover {
        background-color: #f8f9fa;
    }

    .size-radio:checked+.size-option:hover {
        background-color: #0b5ed7;
    }
</style>
