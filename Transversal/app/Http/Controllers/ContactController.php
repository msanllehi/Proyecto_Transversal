<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function submitForm(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);

        // Enviar el correo electrónico
        Mail::to('marcsanrob2005@gmail.com')->send(new ContactMail($validated));

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('status', '¡Gracias! Tu mensaje ha sido enviado correctamente.');
    }
}
