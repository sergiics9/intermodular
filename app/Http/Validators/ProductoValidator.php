<?php

declare(strict_types=1);

namespace App\Http\Validators;

use App\Core\Request;
use App\Models\Categoria;

class PeliculaValidator
{

    public static function validate(Request $request): void
    {
        $errors = [];

        $titulo_valido = trim($request->titulo ?? '') !== '';
        $estreno_valido = filter_var($request->estreno, FILTER_VALIDATE_INT)
            && (int) $request->estreno > 1900
            && (int) $request->estreno <= date('Y');
        $sinopsis_valida = trim($request->sinopsis ?? '') !== '';
        $duracion_valida = filter_var($request->duracion, FILTER_VALIDATE_INT)
            && (int) $request->duracion > 0;
        $director_id_valido = true;

        if ($request->categoria_id !== '') {
            $categoria_id_valido = filter_var($request->categoria_id, FILTER_VALIDATE_INT) &&
                Categoria::find((int) $request->categoria_id);
        }
        if (!$titulo_valido) {
            $errors['titulo'] = 'El título es obligatorio.';
        }

        if (!$categoria_id_valido) {
            $errors['categoria_id'] = 'El director seleccionado no es válido.';
        }

        if (!$estreno_valido) {
            $errors['estreno'] = 'El año de estreno debe ser un número entero entre 1901 y el año actual.';
        }

        if (!$sinopsis_valida) {
            $errors['sinopsis'] = 'La sinopsis es obligatoria.';
        }

        if (!$duracion_valida) {
            $errors['duracion'] = 'La duración debe ser un número entero mayor que 0 minutos.';
        }

        if ($errors) {
            back()->withErrors($errors)->withInput([
                'titulo'   => $request->titulo,
                'estreno'  => $request->estreno,
                'sinopsis' => $request->sinopsis,
                'duracion' => $request->duracion,
                'categoria_id' => $request->director_id,
            ])->send();
        }
    }
}
