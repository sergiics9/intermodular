<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;

class Categoria extends Model
{
    protected static string $table = 'categorias';
    protected static array $fillable = ['nombre'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (nombre) VALUES (?)";
        $params = [(string) $this->nombre];
        DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table SET nombre = ? WHERE id = ?";
        $params = [(string) $this->nombre, (int) $this->id];
        DB::update($sql, $params);
    }

    // Obtener todas las categorías
    public static function getAll(): array
    {
        $sql = "SELECT * FROM " . self::$table;
        return DB::select(self::class, $sql);
    }
}
