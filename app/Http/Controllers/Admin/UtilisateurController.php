<?php
// app/Http/Controllers/Admin/UtilisateurController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $utilisateurs = User::paginate(20);
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        return view('admin.utilisateurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'login' => 'required|string|unique:utilisateurs',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,employe,superviseur'
        ]);

        User::create([
            'login' => $validated['login'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'mot_de_passe_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'statut' => 'actif'
        ]);

        return redirect()->route('admin.utilisateurs.index')
                        ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $utilisateur)
    {
        return view('admin.utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, User $utilisateur)
    {
        $validated = $request->validate([
            'login' => 'required|string|unique:utilisateurs,login,' . $utilisateur->id_user . ',id_user',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id_user . ',id_user',
            'role' => 'required|in:admin,employe,superviseur',
            'statut' => 'required|in:actif,inactif'
        ]);

        $utilisateur->update($validated);

        return redirect()->route('admin.utilisateurs.index')
                        ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $utilisateur)
    {
        $utilisateur->update(['statut' => 'inactif']);
        return redirect()->route('admin.utilisateurs.index')
                        ->with('success', 'Utilisateur désactivé avec succès.');
    }
}