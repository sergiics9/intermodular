<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Voto.php';
require_once __DIR__ . '/../../Models/Pelicula.php';

use App\Models\Voto;
use App\Models\Pelicula; // necesario para la vista
use App\Core\Auth;

class UsuarioController
{

    // public function myVotes()
    // {
    //     $votos = Voto::withPeliculaTitulo()
    //         ->where('usuario_id', Auth::id())
    //         //->where('puntuacion', '>', 8)
    //         //->where('critica', '!=', null)
    //         ->orderBy('pelicula_titulo')->get();

    //     view('usuarios.my-votes', compact('votos'));
    // }
}
