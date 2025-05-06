<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Models\Contacto;

class ContactoController
{
    public function index()
    {
        view('contacto.index');
    }

    public function store(Request $request)
    {
        $contacto = new Contacto();
        $contacto->nombre = $request->nombre;
        $contacto->email = $request->email;
        $contacto->mensaje = $request->mensaje;
        $contacto->save();

        redirect('/contacto/index.php')->with('success', 'Mensaje enviado con éxito')->send();
    }

    public function admin()
    {
        $mensajes = Contacto::all();
        view('contacto.admin', compact('mensajes'));
    }
}
