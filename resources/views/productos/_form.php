<?php
// Definir tallas disponibles
$tallasDisponibles = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
?>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del Producto</label>
    <input type="text" class="form-control <?= isset($errors['nombre']) ? 'is-invalid' : '' ?>"
        id="nombre" name="nombre" value="<?= $values['nombre'] ?? '' ?>" required>
    <?php if (isset($errors['nombre'])): ?>
        <div class="invalid-feedback"><?= $errors['nombre'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="precio" class="form-label">Precio (€)</label>
    <input type="number" step="0.01" min="0" class="form-control <?= isset($errors['precio']) ? 'is-invalid' : '' ?>"
        id="precio" name="precio" value="<?= $values['precio'] ?? '' ?>" required>
    <?php if (isset($errors['precio'])): ?>
        <div class="invalid-feedback"><?= $errors['precio'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control <?= isset($errors['descripcion']) ? 'is-invalid' : '' ?>"
        id="descripcion" name="descripcion" rows="4" required><?= $values['descripcion'] ?? '' ?></textarea>
    <?php if (isset($errors['descripcion'])): ?>
        <div class="invalid-feedback"><?= $errors['descripcion'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría</label>
    <select class="form-select <?= isset($errors['categoria_id']) ? 'is-invalid' : '' ?>"
        id="categoria_id" name="categoria_id" required>
        <option value="">Seleccionar categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria->id ?>"
                <?= (isset($values['categoria_id']) && $values['categoria_id'] == $categoria->id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($categoria->nombre) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['categoria_id'])): ?>
        <div class="invalid-feedback"><?= $errors['categoria_id'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label class="form-label">Tallas Disponibles</label>
    <div class="row">
        <?php foreach ($tallasDisponibles as $talla): ?>
            <div class="col-md-2 col-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="tallas[]" value="<?= $talla ?>" id="talla_<?= $talla ?>"
                        <?= (isset($tallasActuales) && in_array($talla, $tallasActuales)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="talla_<?= $talla ?>">
                        <?= $talla ?>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (isset($errors['tallas'])): ?>
        <div class="text-danger mt-1"><?= $errors['tallas'] ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="imagen" class="form-label">Imagen del Producto</label>
    <input type="file" class="form-control <?= isset($errors['imagen']) ? 'is-invalid' : '' ?>"
        id="imagen" name="imagen" accept="image/*">
    <div class="form-text">Formatos aceptados: JPG, PNG, WEBP. Tamaño máximo: 2MB.</div>
    <?php if (isset($errors['imagen'])): ?>
        <div class="invalid-feedback"><?= $errors['imagen'] ?></div>
    <?php endif; ?>

    <?php if (isset($producto) && $producto->id): ?>
        <div class="mt-2">
            <p>Imagen actual:</p>
            <img src="<?= BASE_URL ?>/images/<?= $producto->id ?>.webp"
                alt="Imagen actual" class="img-thumbnail" style="max-height: 150px;">
        </div>
    <?php endif; ?>
</div>

<!-- Vista previa del producto -->
<div class="mt-4 mb-3">
    <h5>Vista previa</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img id="preview-image" src="<?= isset($producto) && $producto->id ? BASE_URL . '/images/' . $producto->id . '.webp' : BASE_URL . '/images/placeholder.jpg' ?>"
                        class="img-fluid rounded" alt="Vista previa">
                </div>
                <div class="col-md-8">
                    <h5 id="preview-nombre"><?= $values['nombre'] ?? 'Nombre del producto' ?></h5>
                    <p class="text-primary fw-bold" id="preview-precio"><?= isset($values['precio']) ? number_format($values['precio'], 2) : '0.00' ?>€</p>
                    <div class="mb-2">
                        <span class="badge bg-secondary" id="preview-categoria">
                            <?php
                            if (isset($values['categoria_id']) && $values['categoria_id']) {
                                foreach ($categorias as $cat) {
                                    if ($cat->id == $values['categoria_id']) {
                                        echo htmlspecialchars($cat->nombre);
                                        break;
                                    }
                                }
                            } else {
                                echo 'Categoría';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="size-options" id="preview-tallas">
                        <?php
                        if (isset($tallasActuales) && !empty($tallasActuales)) {
                            foreach ($tallasActuales as $talla) {
                                echo '<span class="size-option">' . htmlspecialchars($talla) . '</span> ';
                            }
                        } else {
                            echo '<span class="size-option">S</span> <span class="size-option">M</span> <span class="size-option">L</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Actualizar vista previa en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const nombreInput = document.getElementById('nombre');
        const precioInput = document.getElementById('precio');
        const categoriaSelect = document.getElementById('categoria_id');
        const tallaCheckboxes = document.querySelectorAll('input[name="tallas[]"]');
        const imagenInput = document.getElementById('imagen');

        const previewNombre = document.getElementById('preview-nombre');
        const previewPrecio = document.getElementById('preview-precio');
        const previewCategoria = document.getElementById('preview-categoria');
        const previewTallas = document.getElementById('preview-tallas');
        const previewImage = document.getElementById('preview-image');

        // Actualizar nombre
        nombreInput.addEventListener('input', function() {
            previewNombre.textContent = this.value || 'Nombre del producto';
        });

        // Actualizar precio
        precioInput.addEventListener('input', function() {
            previewPrecio.textContent = (parseFloat(this.value) || 0).toFixed(2) + '€';
        });

        // Actualizar categoría
        categoriaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            previewCategoria.textContent = selectedOption.text !== 'Seleccionar categoría' ? selectedOption.text : 'Categoría';
        });

        // Actualizar tallas
        tallaCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateTallasPreview();
            });
        });

        function updateTallasPreview() {
            previewTallas.innerHTML = '';
            const selectedTallas = Array.from(tallaCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (selectedTallas.length === 0) {
                previewTallas.innerHTML = '<span class="size-option">S</span> <span class="size-option">M</span> <span class="size-option">L</span>';
            } else {
                selectedTallas.forEach(talla => {
                    const span = document.createElement('span');
                    span.className = 'size-option';
                    span.textContent = talla;
                    previewTallas.appendChild(span);
                    previewTallas.appendChild(document.createTextNode(' '));
                });
            }
        }

        // Actualizar imagen
        imagenInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
