<?php

use App\Core\Auth;

// Verificar permisos de administrador
if (!Auth::check() || Auth::role() != 1) {
    redirect('/productos/index.php')->with('error', 'No tienes permisos para acceder a esta página')->send();
}

$errors = escapeArray(session()->getFlash('errors', []));
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crear Nuevo Producto</h4>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/productos/store.php" method="POST" enctype="multipart/form-data">
                        <?php include __DIR__ . '/_form.php'; ?>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/productos/index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
