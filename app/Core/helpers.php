<?php

declare(strict_types=1);

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

//
// Instancias reutilizables relacionadas con la petición
//

/**
 * Devuelve una instancia única de la clase Request para toda la petición.
 *
 * Esta función actúa como un singleton *sin forzar* que la clase Request lo sea.
 * Se puede seguir instanciando Request en otros contextos, como en pruebas.
 */
function request(): Request
{
    static $instance = null;
    if ($instance === null) {
        $instance = new Request();
    }
    return $instance;
}

/**
 * Devuelve una instancia única de la clase Session para la sesión actual.
 *
 * Actúa como acceso global controlado, evitando múltiples instancias no sincronizadas.
 */
function session(): Session
{
    static $instance = null;
    if ($instance === null) {
        $instance = new Session();
    }
    return $instance;
}

//
// Formularios
//

/**
 * Devuelve los valores iniciales de un formulario, priorizando datos antiguos
 * (de una validación fallida anterior) y luego el modelo actual (si existe).
 *
 * @param array $fields Lista de nombres de campos a recuperar.
 * @param object|null $model Objeto del modelo (con propiedades públicas o accesibles).
 * @return array Valores iniciales para el formulario (clave => valor).
 */
function formDefaults(array $fields, ?object $model = null): array
{
    $session = session();
    $old = $session->getFlash('old', []);
    $values = [];

    foreach ($fields as $field) {
        $values[$field] = $old[$field] ?? ($model?->$field ?? '');
    }

    return $values;
}

/**
 * Escapa todos los valores de un array asociativo para uso en HTML.
 * Solo escapa si el valor es una cadena.
 */
function escapeArray(array $data): array
{
    return array_map(function ($value) {
        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }, $data);
}

//
// Respuestas y vistas
//

/**
 * Renderiza una vista con los datos proporcionados.
 */
function view(string $view, array $data = []): void
{
    Response::view($view, $data);
}

/**
 * Realiza una redirección utilizando BASE_URL como prefijo.
 */
function redirect(string $url): Response
{
    return Response::redirect($url);
}

/**
 * Redirige a la URL anterior. Si no está disponible, redirige a HOME.
 */
function back(): Response
{
    return Response::back();
}

/**
 * Devuelve la URL de la página anterior.
 *
 * Si no hay una referencia HTTP disponible, devuelve HOME.
 */
function previousUrl(): string
{
    return $_SERVER['HTTP_REFERER'] ?? HOME;
}

/**
 * Obtiene un valor antiguo del formulario.
 */
function old(string $key, $default = '')
{
    $old = session()->getFlash('old', []);
    return $old[$key] ?? $default;
}

/**
 * Obtiene un mensaje de error para un campo específico.
 */
function error(string $key): ?string
{
    $errors = session()->getFlash('errors', []);
    return $errors[$key] ?? null;
}

/**
 * Verifica si hay un error para un campo específico.
 */
function has_error(string $key): bool
{
    $errors = session()->getFlash('errors', []);
    return isset($errors[$key]);
}

/**
 * Genera un token CSRF.
 */
function csrf_token(): string
{
    $token = session()->get('_token');
    if (!$token) {
        $token = bin2hex(random_bytes(32));
        session()->set('_token', $token);
    }
    return $token;
}

/**
 * Genera un campo oculto con el token CSRF.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

/**
 * Genera un campo oculto con el método HTTP.
 */
function method_field(string $method): string
{
    return '<input type="hidden" name="_method" value="' . $method . '">';
}

/**
 * Genera una URL para un activo.
 */
function asset(string $path): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Genera una URL completa.
 */
function url(string $path): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Función de depuración.
 */
function dd(...$vars): void
{
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    die();
}
