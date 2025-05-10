<?php

use App\Core\Auth;
?>
<div class="container mt-5">
    <h1 class="mb-4">Categorías</h1>

    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <?php if (Auth::check() && Auth::role() == 1): ?>
        <div class="mb-4">
            <a href="<?= BASE_URL ?>/categorias/create.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Nueva Categoría
            </a>
        </div>
    <?php endif; ?>

    <?php if (empty($categorias)): ?>
        <div class="alert alert-info">
            No hay categorías disponibles.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($categoria->nombre) ?></h5>
                            <p class="card-text">
                                <span class="badge bg-primary"><?= $categoria->cantidad_productos ?> productos</span>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL ?>/categorias/show.php?id=<?= $categoria->id ?>" class="btn btn-outline-primary">
                                    Ver productos
                                </a>

                                <?php if (Auth::check() && Auth::role() == 1): ?>
                                    <div>
                                        <a href="<?= BASE_URL ?>/categorias/edit.php?id=<?= $categoria->id ?>" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <?php if ($categoria->cantidad_productos == 0): ?>
                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $categoria->id ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                            <!-- Modal de confirmación para eliminar -->
                                            <div class="modal fade" id="deleteModal<?= $categoria->id ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $categoria->id ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel<?= $categoria->id ?>">Confirmar eliminación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar la categoría <strong><?= htmlspecialchars($categoria->nombre) ?></strong>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="<?= BASE_URL ?>/categorias/destroy.php" method="POST">
                                                                <input type="hidden" name="id" value="<?= $categoria->id ?>">
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
