<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister()
    {
        return view('register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birth_date' => 'required|date_format:d/m/Y',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'billing_address' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Convertir formato de fecha DD/MM/YYYY a YYYY-MM-DD para almacenar en la base de datos
        $birthDateParts = explode('/', $request->birth_date);
        $birthDate = $birthDateParts[2] . '-' . $birthDateParts[1] . '-' . $birthDateParts[0];

        // Si no se proporciona dirección de facturación, usar la dirección principal
        $billingAddress = $request->billing_address ?: $request->address;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birth_date' => $birthDate,
            'phone' => $request->phone,
            'address' => $request->address,
            'billing_address' => $billingAddress,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'password' => Hash::make($request->password),
            'email_verification_token' => Str::random(60),
            'role' => 'client',
        ]);

        // Send verification email
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        Mail::send('emails.verify', ['url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email)->subject('Verifica tu correo electrónica');
        });

        event(new Registered($user));
        Auth::logout();
        return redirect()->route('login')->with('status', 'Comprueba tu correo para verificar tu cuenta.');
    }

    // Show login form
    public function showLogin()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Tienes que verificar primero tu correo para acceder.']);
            }
            return redirect()->intended('/');
        }
        return back()->withErrors(['email' => 'Datos incorrectos.'])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Handle email verification
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403);
        }
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
        Auth::login($user);
        return redirect('/')->with('status', 'Correo verificado correctamente!');
    }
}
