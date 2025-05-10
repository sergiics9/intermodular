<?php

use App\Core\Auth;

// Verificar permisos de administrador
if (!Auth::check() || Auth::role() !== 1) {
    redirect('/categorias/index.php')->with('error', 'No tienes permisos para acceder a esta página')->send();
}

// Obtener valores para el formulario
$values = [];
$old = session()->getFlash('old', []);

if (!empty($old)) {
    $values['nombre'] = $old['nombre'] ?? ($categoria->nombre ?? '');
} else {
    $values['nombre'] = $categoria->nombre ?? '';
}

$errors = escapeArray(session()->getFlash('errors', []));
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Categoría</h4>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/categorias/update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $categoria->id ?>">
                        <?php include __DIR__ . '/_form.php'; ?>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/categorias/index.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
