<?php

declare(strict_types=1);

namespace App\Http\Validators;

use App\Core\Request;
use App\Models\Categoria;

class ProductoValidator
{
    public static function validate(Request $request): void
    {
        $errors = [];

        // Validar nombre
        if (empty(trim($request->nombre ?? ''))) {
            $errors['nombre'] = 'El nombre del producto es obligatorio.';
        }

        // Validar precio
        $precio = $request->precio;
        if (is_string($precio)) {
            // Reemplazar coma por punto si es necesario
            $precio = str_replace(',', '.', $precio);
        }

        if (empty($precio) || !is_numeric($precio) || (float)$precio <= 0) {
            $errors['precio'] = 'El precio debe ser un número mayor que cero.';
        }

        // Validar descripción
        if (empty(trim($request->descripcion ?? ''))) {
            $errors['descripcion'] = 'La descripción del producto es obligatoria.';
        }

        // Validar categoría
        $categoria_id = $request->categoria_id;
        if (empty($categoria_id)) {
            $errors['categoria_id'] = 'Debe seleccionar una categoría.';
        } else {
            $categoria = Categoria::find((int)$categoria_id);
            if (!$categoria) {
                $errors['categoria_id'] = 'La categoría seleccionada no es válida.';
            }
        }

        // Validar tallas
        // Acceder directamente a $_POST para evitar problemas con la propiedad mágica
        $tallas = $_POST['tallas'] ?? [];

        if (empty($tallas) || !is_array($tallas) || count($tallas) === 0) {
            $errors['tallas'] = 'Debe seleccionar al menos una talla.';
        }

        // Validar imagen (si se ha subido)
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
                $errors['imagen'] = 'Error al subir la imagen. Por favor, inténtelo de nuevo.';
            } elseif (!in_array($_FILES['imagen']['type'], $allowedTypes)) {
                $errors['imagen'] = 'El formato de la imagen no es válido. Use JPG, PNG o WEBP.';
            } elseif ($_FILES['imagen']['size'] > $maxSize) {
                $errors['imagen'] = 'La imagen es demasiado grande. El tamaño máximo es 2MB.';
            }
        }

        if ($errors) {
            back()->withErrors($errors)->withInput([
                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'descripcion' => $request->descripcion,
                'categoria_id' => $request->categoria_id,
                'tallas' => $_POST['tallas'] ?? [],
            ])->send();
        }
    }
}
