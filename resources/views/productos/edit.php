<?php

use App\Core\Auth;
use App\Core\DB;

// Verificar permisos de administrador
if (!Auth::check() || Auth::role() !== 1) {
    redirect('/productos/index.php')->with('error', 'No tienes permisos para acceder a esta página')->send();
    exit;
}

// Obtener valores del producto para el formulario
$fields = ['nombre', 'precio', 'descripcion', 'categoria_id'];
$values = [];

// Primero intentar obtener valores de la sesión (en caso de error de validación)
$old = session()->getFlash('old', []);
if (!empty($old)) {
    foreach ($fields as $field) {
        $values[$field] = $old[$field] ?? ($producto->$field ?? '');
    }
} else {
    // Si no hay valores en la sesión, usar los del producto
    foreach ($fields as $field) {
        $values[$field] = $producto->$field ?? '';
    }
}

$errors = escapeArray(session()->getFlash('errors', []));

// Obtener las tallas actuales del producto
$tallasActuales = [];
if (isset($producto)) {
    $sql = "SELECT tallas FROM tallas WHERE id_producto = ?";
    $tallasResult = DB::selectAssoc($sql, [$producto->id]);
    foreach ($tallasResult as $talla) {
        $tallasActuales[] = $talla['tallas'];
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Producto</h4>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../partials/messages.php'; ?>
                    <?php include __DIR__ . '/../partials/errors.php'; ?>

                    <form action="<?= BASE_URL ?>/productos/update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $producto->id ?>">
                        <?php include __DIR__ . '/_form.php'; ?>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/productos/show.php?id=<?= $producto->id ?>" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
