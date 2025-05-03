<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Producto;
use App\Models\Categoria;

class ProductoController
{
    public function mostrarProductos(array $params): void
    {
        $min = $params['min'] ?? 0;
        $max = $params['max'] ?? 250;
        $busqueda = $params['busqueda'] ?? '';
        $categoria = $params['categoria'] ?? 0;
        $orden = $params['orden'] ?? '';

        $productos = Producto::getProductosFiltrados($min, $max, $busqueda, $categoria, $orden);
        $categorias = Categoria::getAll();

        require 'views/productos.php';
    }
}
