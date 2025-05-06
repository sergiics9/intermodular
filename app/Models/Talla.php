<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;

class Talla extends Model
{
    protected static string $table = 'tallas';
    protected static array $fillable = ['id_producto', 'tallas'];
    protected static array $relations = ['producto'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (id_producto, tallas)"
            . " VALUES (?, ?)";
        $params = [$this->id_producto, $this->tallas];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET id_producto = ?, tallas = ?"
            . " WHERE id = ?";
        $params = [$this->id_producto, $this->tallas, $this->id];
        DB::update($sql, $params);
    }

    public function producto(): ?Producto
    {
        return Producto::find($this->id_producto);
    }
}
