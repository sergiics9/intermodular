<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;

class Talla extends Model
{
    protected static string $table = 'tallas';
    protected static array $fillable = ['tallas', 'id_producto'];

    /** @override */
    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table . " (tallas, id_producto) VALUES (?, ?)";
        $params = [
            (string) $this->tallas,
            (int) $this->id_producto
        ];
        DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $sql = "UPDATE " . self::$table . " SET tallas = ? WHERE id_producto = ?";
        $params = [
            (string) $this->tallas,
            (int) $this->id_producto
        ];
        DB::update($sql, $params);
    }

    public static function findByProductId(int $id_producto): array
    {
        $sql = "SELECT tallas FROM " . self::$table . " WHERE id_producto = ?";
        $params = [(int) $id_producto];
        return DB::select(self::class, $sql, $params);
    }
}
