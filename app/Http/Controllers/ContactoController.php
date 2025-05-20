<?php

declare(strict_types=1);

namespace App\Http\Controllers;

require_once __DIR__ . '/../../Models/Contacto.php';

use App\Core\Request;
use App\Core\Auth;
use App\Models\Contacto;

class ContactoController
{
    public function index()
    {
        view('contacto.index');
    }

    public function store(Request $request)
    {
        // Validar datos
        $errors = [];

        if (empty(trim($request->nombre))) {
            $errors['nombre'] = 'El nombre es obligatorio';
        }

        if (empty(trim($request->email))) {
            $errors['email'] = 'El email es obligatorio';
        } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es válido';
        }

        if (empty(trim($request->mensaje))) {
            $errors['mensaje'] = 'El mensaje es obligatorio';
        }

        if (!empty($errors)) {
            back()->withErrors($errors)->withInput([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'mensaje' => $request->mensaje
            ])->send();
        }

        // Crear y guardar el mensaje de contacto
        $contacto = new Contacto();
        $contacto->nombre = trim($request->nombre);
        $contacto->email = trim($request->email);
        $contacto->mensaje = trim($request->mensaje);
        $contacto->save();

        redirect('/contacto/index.php')->with('success', 'Mensaje enviado con éxito. Nos pondremos en contacto contigo pronto.')->send();
    }

    public function admin()
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $mensajes = Contacto::orderBy('fecha_envio', 'DESC')->get();
        view('contacto.admin', compact('mensajes'));
    }

    public function destroy(Request $request)
    {
        // Verificar permisos de administrador
        if (!Auth::check() || Auth::role() !== 1) {
            http_response_code(403);
            view('errors.403');
            exit;
        }

        $contacto = Contacto::findOrFail((int)$request->id);
        $contacto->delete();

        redirect('/contacto/admin.php')->with('success', 'Mensaje eliminado con éxito')->send();
    }
}
