<?php
$fields = ['titulo', 'director_id', 'estreno', 'sinopsis', 'duracion'];
$values = escapeArray(formDefaults($fields, $pelicula ?? null));
$errors = escapeArray(session()->getFlash('errors', []));
?>

<div class="container mt-4">
    <h2>Editar Película</h2>

    <!-- Mostrar errores si existen -->
    <?php include __DIR__ . '/../partials/errors.php'; ?>

    <!-- Formulario de edición -->
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $pelicula->id ?>">
        <?php include __DIR__ . '/_form.php'; ?>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= previousUrl() ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
