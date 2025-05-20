<?php

namespace App\Core;

class Session
{
    /**
     * Inicia la sesión si no está ya iniciada.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize flash data storage if it doesn't exist
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [];
        }

        // Initialize _flash_old for storing flash data that has been accessed
        if (!isset($_SESSION['_flash_old'])) {
            $_SESSION['_flash_old'] = [];
        }

        // Move any accessed flash data from previous request to _flash_old
        // and clear it after it's been accessed once
        $this->clearOldFlashData();
    }

    /**
     * Obtiene un valor de la sesión
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Establece un valor en la sesión
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Verifica si existe una variable de sesión y es distinta de null
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /** 
     * Elimina una variable de sesión
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Obtiene el valor de una variable de sesión flash y lo marca para eliminación.
     * En la próxima petición, la variable será eliminada.
     */
    public function getFlash(string $key, $default = null)
    {
        if (!isset($_SESSION['_flash'][$key])) {
            return $default;
        }

        // Get the value
        $value = $_SESSION['_flash'][$key];

        // Mark this key as accessed so it will be cleared on next request
        $_SESSION['_flash_old'][$key] = true;

        return $value;
    }

    /**
     * Establece un valor flash.
     */
    public function flash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Verifica si existe un valor flash.
     */
    public function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Elimina todos los valores flash que han sido accedidos.
     */
    private function clearOldFlashData(): void
    {
        // Remove flash data that was accessed in the previous request
        foreach ($_SESSION['_flash_old'] as $key => $accessed) {
            unset($_SESSION['_flash'][$key]);
        }

        // Reset the _flash_old array for the current request
        $_SESSION['_flash_old'] = [];
    }

    /**
     * Reinicia completamente la sesión actual.
     */
    public function invalidate(): void
    {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
    }
}
