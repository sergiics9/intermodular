<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;
use App\Core\QueryBuilder;

class Comentario extends Model
{
    protected static string $table = 'comentarios';
    protected static array $fillable = ['producto_id', 'usuario_id', 'texto', 'fecha'];
    protected static array $relations = ['producto', 'usuario'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (producto_id, usuario_id, texto, fecha)"
            . " VALUES (?, ?, ?, ?)";
        $params = [$this->producto_id, $this->usuario_id, $this->texto, $this->fecha ?? date('Y-m-d H:i:s')];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET producto_id = ?, usuario_id = ?, texto = ?"
            . " WHERE id = ?";
        $params = [$this->producto_id, $this->usuario_id, $this->texto, $this->id];
        DB::update($sql, $params);
    }

    public function producto(): ?Producto
    {
        return Producto::find($this->producto_id);
    }

    public function usuario(): ?Usuario
    {
        return Usuario::find($this->usuario_id);
    }
}
