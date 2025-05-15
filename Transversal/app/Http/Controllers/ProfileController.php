<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:d/m/Y',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Convertir formato de fecha DD/MM/YYYY a YYYY-MM-DD para almacenar en la base de datos
        $birthDateParts = explode('/', $request->birth_date);
        $birthDate = $birthDateParts[2] . '-' . $birthDateParts[1] . '-' . $birthDateParts[0];
        
        // Si no se proporciona dirección de facturación, usar la dirección principal
        $billingAddress = $request->billing_address ?: $request->address;
        
        // Actualizar datos básicos
        $user->name = $request->name;
        // El email no se puede cambiar
        $user->birth_date = $birthDate;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->billing_address = $billingAddress;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        
        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        
        return redirect()->route('profile.show')->with('status', 'Perfil actualizado correctamente!');
    }
}
