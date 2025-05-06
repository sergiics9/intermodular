<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;

class DetallePedido extends Model
{
    protected static string $table = 'detalles_pedido';
    protected static array $fillable = ['PedidoID', 'ProductoID', 'Cantidad', 'Precio', 'talla'];
    protected static array $relations = ['pedido', 'producto'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (PedidoID, ProductoID, Cantidad, Precio, talla)"
            . " VALUES (?, ?, ?, ?, ?)";
        $params = [$this->PedidoID, $this->ProductoID, $this->Cantidad, $this->Precio, $this->talla];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET PedidoID = ?, ProductoID = ?, Cantidad = ?, Precio = ?, talla = ?"
            . " WHERE DetalleID = ?";
        $params = [$this->PedidoID, $this->ProductoID, $this->Cantidad, $this->Precio, $this->talla, $this->DetalleID];
        DB::update($sql, $params);
    }

    public function pedido(): ?Pedido
    {
        return Pedido::find($this->PedidoID);
    }

    public function producto(): ?Producto
    {
        return Producto::find($this->ProductoID);
    }

    public function __get($name)
    {
        if ($name === 'id') {
            return $this->DetalleID;
        }
        return parent::__get($name);
    }
}
