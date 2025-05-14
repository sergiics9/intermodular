<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;
use App\Core\QueryBuilder;

class Usuario extends Model
{
    protected static string $table = 'usuarios';
    protected static array $fillable = ['nombre', 'contraseña', 'email', 'telefono', 'role', 'ip_registro'];
    protected static array $relations = ['pedidos'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (nombre, contraseña, email, telefono, role, ip_registro)"
            . " VALUES (?, ?, ?, ?, ?, ?)";
        $params = [$this->nombre, $this->contraseña, $this->email, $this->telefono, $this->role, $this->ip_registro];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET nombre = ?, contraseña = ?, email = ?, telefono = ?, role = ?"
            . " WHERE id = ?";
        $params = [$this->nombre, $this->contraseña, $this->email, $this->telefono, $this->role, $this->id];
        DB::update($sql, $params);
    }

    public function pedidos(): QueryBuilder
    {
        return Pedido::where('UsuarioID', $this->id);
    }

    public function isAdmin(): bool
    {
        return $this->role == 1;
    }
}
