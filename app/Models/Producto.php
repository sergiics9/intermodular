<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;

class Producto extends Model
{
    protected static string $table = 'productos';
    protected static array $fillable = ['nombre', 'precio', 'descripcion', 'categoria_id', 'fecha_creacion'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (nombre, precio, descripcion, categoria_id, fecha_creacion) VALUES (?, ?, ?, ?, ?)";
        $params = [
            (string) $this->nombre,
            (float) $this->precio,
            (string) $this->descripcion,
            (int) $this->categoria_id,
            (string) $this->fecha_creacion
        ];
        DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table SET nombre = ?, precio = ?, descripcion = ?, categoria_id = ?, fecha_creacion = ? WHERE id = ?";
        $params = [
            (string) $this->nombre,
            (float) $this->precio,
            (string) $this->descripcion,
            (int) $this->categoria_id,
            (string) $this->fecha_creacion,
            (int) $this->id
        ];
        DB::update($sql, $params);
    }

    // Método para filtrar productos por precio
    public static function getProductosFiltrados(int $min, int $max, string $busqueda = '', int $categoria = 0, string $orden = ''): array
    {
        $sql = "SELECT * FROM " . self::$table . " WHERE precio BETWEEN ? AND ?";
        $params = [(int) $min, (int) $max];

        if (!empty($busqueda)) {
            $sql .= " AND nombre LIKE ?";
            $params[] = '%' . (string)$busqueda . '%';
        }

        if ($categoria > 0) {
            $sql .= " AND categoria_id = ?";
            $params[] = (int) $categoria;
        }

        switch ($orden) {
            case 'nombre_asc':
                $sql .= " ORDER BY nombre ASC";
                break;
            case 'nombre_desc':
                $sql .= " ORDER BY nombre DESC";
                break;
            case 'precio_asc':
                $sql .= " ORDER BY precio ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY precio DESC";
                break;
            case 'novedades':
                $sql .= " ORDER BY fecha_creacion DESC";
                break;
        }

        return DB::select(self::class, $sql, $params);
    }

    // Relación con las tallas
    public function tallas(): array
    {
        $sql = "SELECT tallas FROM tallas WHERE id_producto = ?";
        return DB::select(self::class, $sql, [(int)$this->id]);
    }
}
