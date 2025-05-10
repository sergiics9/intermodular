<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\DB;

class Contacto extends Model
{
    protected static string $table = 'contacto';
    protected static array $fillable = ['nombre', 'email', 'mensaje', 'fecha_envio'];

    public function insert(): void
    {
        $sql = "INSERT INTO " . self::$table
            . " (nombre, email, mensaje, fecha_envio)"
            . " VALUES (?, ?, ?, NOW())";
        $params = [$this->nombre, $this->email, $this->mensaje];
        $this->id = DB::insert($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE " . self::$table
            . " SET nombre = ?, email = ?, mensaje = ?"
            . " WHERE id = ?";
        $params = [$this->nombre, $this->email, $this->mensaje, $this->id];
        DB::update($sql, $params);
    }
}
