<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" class="form-control <?= isset($errors['titulo']) ? 'is-invalid' : '' ?>"
        id="titulo" name="titulo" value="<?= $values['titulo'] ?>">
    <?php if (isset($errors['titulo'])): ?>
        <div class="invalid-feedback"><?= $errors['titulo'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="director_id" class="form-label">Director</label>
    <select class="form-select <?= isset($errors['director_id']) ? 'is-invalid' : '' ?>"
        id="director_id" name="director_id">
        <option value="">-- Sin director --</option>
        <?php foreach ($directores as $director): ?>
            <option value="<?= $director->id ?>"
                <?= $values['director_id'] == $director->id ? 'selected' : '' ?>>
                <?= htmlspecialchars($director->nombre) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['director_id'])): ?>
        <div class="invalid-feedback"><?= $errors['director_id'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="estreno" class="form-label">Año de Estreno</label>
    <input type="number" class="form-control <?= isset($errors['estreno']) ? 'is-invalid' : '' ?>"
        id="estreno" name="estreno" value="<?= $values['estreno'] ?>">
    <?php if (isset($errors['estreno'])): ?>
        <div class="invalid-feedback"><?= $errors['estreno'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="sinopsis" class="form-label">Sinopsis</label>
    <textarea class="form-control <?= isset($errors['sinopsis']) ? 'is-invalid' : '' ?>"
        id="sinopsis" name="sinopsis" rows="4"><?= $values['sinopsis'] ?></textarea>
    <?php if (isset($errors['sinopsis'])): ?>
        <div class="invalid-feedback"><?= $errors['sinopsis'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="duracion" class="form-label">Duración (en minutos)</label>
    <input type="number" class="form-control <?= isset($errors['duracion']) ? 'is-invalid' : '' ?>"
        id="duracion" name="duracion" value="<?= $values['duracion'] ?>">
    <?php if (isset($errors['duracion'])): ?>
        <div class="invalid-feedback"><?= $errors['duracion'] ?></div>
    <?php endif; ?>
</div>
