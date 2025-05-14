<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;
use App\Core\QueryBuilder;

class Pedido extends Model
{
    protected static string $table = 'pedidos';
    protected static array $fillable = ['UsuarioID', 'Nombre', 'Email', 'Direccion', 'Telefono', 'Total', 'Fecha'];
    protected static array $relations = ['detalles', 'usuario'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (UsuarioID, Nombre, Email, Direccion, Telefono, Total)"
            . " VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$this->UsuarioID, $this->Nombre, $this->Email, $this->Direccion, $this->Telefono, $this->Total];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET UsuarioID = ?, Nombre = ?, Email = ?, Direccion = ?, Telefono = ?, Total = ?"
            . " WHERE id = ?";
        $params = [$this->UsuarioID, $this->Nombre, $this->Email, $this->Direccion, $this->Telefono, $this->Total, $this->id];
        DB::update($sql, $params);
    }

    public function detalles(): QueryBuilder
    {
        return DetallePedido::where('id', $this->id);
    }

    public function usuario(): ?Usuario
    {
        if ($this->UsuarioID === null) {
            return null;
        }
        return Usuario::find($this->UsuarioID);
    }

    public function __get($name)
    {
        if ($name === 'id') {
            return $this->id;
        }
        return parent::__get($name);
    }
}
