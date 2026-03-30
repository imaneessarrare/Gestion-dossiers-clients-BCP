<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User; // Utiliser User au lieu de Utilisateur
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
                    ->where('statut', 'actif')
                    ->first();

        if ($user && Hash::check($request->password, $user->mot_de_passe_hash)) {
            Auth::login($user, $request->boolean('remember'));
            $user->update(['derniere_connexion' => now()]);
            
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}