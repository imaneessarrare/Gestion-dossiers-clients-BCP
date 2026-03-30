<?php
// app/Http/Controllers/ClientController.php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();
        
        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('cin', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $clients = $query->withCount(['comptes', 'impayes'])
                         ->latest()
                         ->paginate(20);
        
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'cin' => 'required|string|unique:clients',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'situation_professionnelle' => 'nullable|string',
            'revenus_mensuels' => 'nullable|numeric|min:0'
        ]);

        $validated['id_user_creation'] = Auth::id();
        $validated['statut'] = 'actif';

        $client = Client::create($validated);

        return redirect()->route('clients.show', $client)
                        ->with('success', 'Client créé avec succès.');
    }

  // app/Http/Controllers/ClientController.php - Méthode show

public function show(Client $client)
{
    // Charger automatiquement les crédits et impayés du client
    $client->load([
        'comptes' => function($q) {
            $q->with('operations')->latest();
        }, 
        'credits' => function($q) {
            $q->with(['echeances' => function($query) {
                $query->orderBy('date_echeance');
            }])->latest();
        }, 
        'impayes' => function($q) {
            $q->latest();
        },
        'moyensPaiement'
    ]);

    // Statistiques automatiques du client
    $totalCredits = $client->credits->sum('montant');
    $totalImpayes = $client->impayes->whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->sum('montant');
    $creditsEnCours = $client->credits->whereIn('statut', ['en_cours', 'en_retard'])->count();

    return view('clients.show', compact('client', 'totalCredits', 'totalImpayes', 'creditsEnCours'));
}
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'date_naissance' => 'required|date',
            'cin' => 'required|string|unique:clients,cin,' . $client->id_client . ',id_client',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'situation_professionnelle' => 'nullable|string',
            'revenus_mensuels' => 'nullable|numeric|min:0'
        ]);

        $client->update($validated);

        return redirect()->route('clients.show', $client)
                        ->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Client $client)
    {
        $client->update(['statut' => 'archive']);
        
        return redirect()->route('clients.index')
                        ->with('success', 'Client archivé avec succès.');
    }
}