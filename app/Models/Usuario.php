<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;
use App\Core\Model;

class Usuario extends Model
{
    protected static string $table = 'usuarios';
    protected static array $fillable = ['nombre', 'email', 'role'];

    /** @override */
    public function insert(): void
    {
        $table = self::$table;
        $sql = "INSERT INTO $table (nombre, email, role) VALUES (?, ?, ?)";
        $params = [(string) $this->nombre, (string) $this->email, (int) $this->role];
        DB::insert($sql, $params);
    }

    /** @override */
    public function update(): void
    {
        $table = self::$table;
        $sql = "UPDATE $table SET nombre = ?, email = ?, role = ? WHERE id = ?";
        $params = [(string) $this->nombre, (string) $this->email, (int) $this->role, (int) $this->id];
        DB::update($sql, $params);
    }

    // Método de autenticación
    public static function authenticate(string $email, string $password): ?self
    {
        $sql = "SELECT * FROM " . self::$table . " WHERE email = ? AND password = ?";
        $params = [(string) $email, (string) $password];
        $result = DB::select(self::class, $sql, $params);
        return !empty($result) ? new self($result[0]) : null;
    }
}
