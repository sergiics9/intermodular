<div class="mb-3">
    <label for="nombre" class="form-label">Nombre de la Categoría</label>
    <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
        id="nombre" name="nombre" value="<?= $values['nombre'] ?? '' ?>" required>
    <?php if (isset($errors['nombre'])): ?>
        <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
    <?php endif; ?>
</div>
