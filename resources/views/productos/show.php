<?php

use App\Core\Auth;

$fields = ['puntuacion', 'critica'];
$values = escapeArray(formDefaults($fields));
$errors = escapeArray(session()->getFlash('errors', []));
?>

<div class="container mt-4">
    <!-- Mostrar mensajes de error y éxito si existen -->
    <?php include __DIR__ . '/../partials/messages.php'; ?>

    <!-- Mostrar errores si existen -->
    <?php include __DIR__ . '/../partials/errors.php'; ?>

    <h1 class="mb-2"><?= htmlspecialchars($pelicula->titulo) ?></h1>
    <h4 class="mb-3">
        <?= $pelicula->director ? htmlspecialchars($pelicula->director->nombre) : 'Sin director' ?>
    </h4>
    <div class="mb-3">
        <?= htmlspecialchars($pelicula->sinopsis) ?>
    </div>
    <p class="mb-4">
        <?= htmlspecialchars($pelicula->estreno) ?> · <?= htmlspecialchars($pelicula->duracion) ?> min
    </p>

    <?php $premios = $pelicula->premios; ?>
    <?php if (!empty($premios)): ?>
        <div class="card mb-4 p-3">
            <h5>Premios</h5>
            <?php foreach ($premios as $premio): ?>
                <div><?= htmlspecialchars($premio->nombre) ?> (<?= htmlspecialchars($premio->edicion) ?>)</div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php $votos = $pelicula->votos()->where('critica', "!=", null)->get(); ?>
    <?php if (!empty($votos)): ?>
        <div class="card mb-4 p-3">
            <h5>Críticas de los usuarios</h5>
            <?php foreach ($votos as $voto): ?>
                <div class="mb-3">
                    <strong><?= htmlspecialchars($voto->usuario->nombre ?? 'Anónimo') ?></strong>
                    <span class="text-muted">(<?= $voto->puntuacion ?>/10)</span>
                    <div style="white-space: pre-wrap;"><?= htmlspecialchars($voto->critica) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


    <?php if (Auth::check()): ?>
        <div class="card mb-4 p-3">
            <h5>Votar esta película</h5>
            <form action="<?= BASE_URL . '/votos/store.php' ?>" method="POST">
                <input type="hidden" name="pelicula_id" value="<?= $pelicula->id ?>">
                <div class="mb-3">
                    <input
                        type="number" name="puntuacion"
                        class="form-control "
                        min="0" max="10" required
                        placeholder="Puntuación (1 a 10)"
                        value="<?= $values['puntuacion'] ?>">
                    <?php if (isset($errors['puntuacion'])): ?>
                        <div class="invalid-feedback d-block"><?= $errors['puntuacion'] ?></div>
                    <?php endif; ?>
                </div>
                <textarea
                    name="critica"
                    class="form-control"
                    rows="4"
                    placeholder="Crítica (opcional)"><?= $values['critica'] ?></textarea>
                <button type="submit" class="btn btn-primary">Enviar voto</button>
            </form>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Inicia sesión para votar y dejar una crítica.</div>
    <?php endif; ?>

    <a href="<?= previousUrl() ?>" class="btn btn-outline-secondary mt-3">← Volver</a>

</div>
