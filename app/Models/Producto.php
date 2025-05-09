<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;
use App\Core\QueryBuilder;

class Producto extends Model
{
    protected static string $table = 'productos';
    protected static array $fillable = ['nombre', 'precio', 'descripcion', 'categoria_id'];
    protected static array $relations = ['categoria', 'tallas', 'detallesPedido', 'comentarios'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (nombre, precio, descripcion, categoria_id)"
            . " VALUES (?, ?, ?, ?)";
        $params = [$this->nombre, $this->precio, $this->descripcion, $this->categoria_id];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET nombre = ?, precio = ?, descripcion = ?, categoria_id = ?"
            . " WHERE id = ?";
        $params = [$this->nombre, $this->precio, $this->descripcion, $this->categoria_id, $this->id];
        DB::update($sql, $params);
    }

    public function categoria(): ?Categoria
    {
        if ($this->categoria_id === null) {
            return null;
        }
        return Categoria::find($this->categoria_id);
    }

    public function tallas(): QueryBuilder
    {
        return Talla::where('id_producto', $this->id);
    }

    public function detallesPedido(): QueryBuilder
    {
        return DetallePedido::where('ProductoID', $this->id);
    }

    public function comentarios(): QueryBuilder
    {
        return Comentario::where('producto_id', $this->id)->orderBy('fecha', 'DESC');
    }

    public function tallasDisponibles(): array
    {
        $tallas = $this->tallas()->get();
        $resultado = [];

        foreach ($tallas as $talla) {
            $resultado[] = $talla->tallas;
        }

        return $resultado;
    }
}
