<?php
// app/Http/Controllers/ParametreController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ParametreController extends Controller
{
    public function index()
    {
        return view('parametres.index');
    }

    public function update(Request $request)
    {
        // Logique pour sauvegarder les paramètres
        return redirect()->route('parametres.index')
                        ->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function verifierImpayes()
    {
        Artisan::call('impayes:verifier');
        return back()->with('success', 'Vérification des impayés effectuée.');
    }
}