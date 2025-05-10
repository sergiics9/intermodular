<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;
use App\Core\QueryBuilder;

class Categoria extends Model
{
    protected static string $table = 'categorias';
    protected static array $fillable = ['nombre'];
    protected static array $relations = ['productos'];
    protected static array $aggregates = ['cantidad_productos']; // Añadimos esta línea

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (nombre)"
            . " VALUES (?)";
        $params = [$this->nombre];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET nombre = ?"
            . " WHERE id = ?";
        $params = [$this->nombre, $this->id];
        DB::update($sql, $params);
    }

    public function productos(): QueryBuilder
    {
        return Producto::where('categoria_id', $this->id);
    }
}
