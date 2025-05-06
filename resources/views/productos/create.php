<?php
$fields = ['titulo', 'director_id', 'estreno', 'sinopsis', 'duracion'];
$values = escapeArray(formDefaults($fields, $pelicula ?? null));
$errors = escapeArray(session()->getFlash('errors', []));
?>

<div class="container mt-4">
    <h2>Añadir Película</h2>

    <!-- Mostrar errores si existen -->
    <?php include __DIR__ . '/../partials/errors.php'; ?>

    <!-- Formulario de Creación -->
    <form action="store.php" method="POST">
        <?php include __DIR__ . '/_form.php'; ?>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= previousUrl() ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
