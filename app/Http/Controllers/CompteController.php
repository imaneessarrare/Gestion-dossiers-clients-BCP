<?php
// app/Http/Controllers/CompteController.php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Client;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompteController extends Controller
{
    public function index(Request $request)
    {
        $query = Compte::with('client');
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('numero_compte', 'LIKE', "%{$request->search}%")
                  ->orWhereHas('client', function($clientQuery) use ($request) {
                      $clientQuery->where('nom', 'LIKE', "%{$request->search}%")
                                  ->orWhere('prenom', 'LIKE', "%{$request->search}%");
                  });
            });
        }
        
        if ($request->has('type')) {
            $query->where('type_compte', $request->type);
        }
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $comptes = $query->paginate(20);
        
        return view('comptes.index', compact('comptes'));
    }
    
    public function create()
    {
        $clients = Client::where('statut', 'actif')->get();
        return view('comptes.create', compact('clients'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id_client',
            'type_compte' => 'required|in:courant,epargne,joint',
            'solde_initial' => 'required|numeric|min:0',
            'date_ouverture' => 'required|date'
        ]);
        
        DB::transaction(function() use ($validated) {
            // Générer un numéro de compte unique
            $numero = 'FR' . date('Y') . str_pad(Compte::max('id_compte') + 1, 8, '0', STR_PAD_LEFT);
            
            $compte = Compte::create([
                'numero_compte' => $numero,
                'type_compte' => $validated['type_compte'],
                'solde' => $validated['solde_initial'],
                'date_ouverture' => $validated['date_ouverture'],
                'id_client' => $validated['id_client'],
                'statut' => 'actif'
            ]);
            
            // Enregistrer l'opération initiale si solde > 0
            if ($validated['solde_initial'] > 0) {
                $compte->operations()->create([
                    'type_operation' => 'depot',
                    'montant' => $validated['solde_initial'],
                    'libelle' => 'Dépôt initial',
                    'date_operation' => $validated['date_ouverture']
                ]);
            }
        });
        
        return redirect()->route('comptes.index')
                        ->with('success', 'Compte créé avec succès.');
    }
    
    public function show(Compte $compte)
    {
        $compte->load('client');
        
        $operations = $compte->operations()
                            ->with('compteDestinataire')
                            ->latest('date_operation')
                            ->paginate(50);
        
        return view('comptes.show', compact('compte', 'operations'));
    }
    
    public function edit(Compte $compte)
    {
        // Supprimer $this->authorize('update', $compte);
        return view('comptes.edit', compact('compte'));
    }
    
    public function update(Request $request, Compte $compte)
    {
        // Supprimer $this->authorize('update', $compte);
        
        $validated = $request->validate([
            'statut' => 'required|in:actif,bloque,ferme'
        ]);
        
        $compte->update($validated);
        
        return redirect()->route('comptes.show', $compte)
                        ->with('success', 'Compte mis à jour avec succès.');
    }
    
    public function destroy(Compte $compte)
    {
        // Vérifier si le compte peut être supprimé (solde à 0)
        if ($compte->solde != 0) {
            return redirect()->back()
                            ->with('error', 'Impossible de supprimer un compte avec un solde non nul.');
        }
        
        $compte->update(['statut' => 'ferme']);
        
        return redirect()->route('comptes.index')
                        ->with('success', 'Compte fermé avec succès.');
    }
    
    public function operations(Compte $compte, Request $request)
    {
        $query = $compte->operations();
        
        if ($request->has('date_debut')) {
            $query->where('date_operation', '>=', $request->date_debut);
        }
        
        if ($request->has('date_fin')) {
            $query->where('date_operation', '<=', $request->date_fin);
        }
        
        if ($request->has('type')) {
            $query->where('type_operation', $request->type);
        }
        
        $operations = $query->latest('date_operation')->get();
        
        return view('comptes.operations', compact('compte', 'operations'));
    }
}