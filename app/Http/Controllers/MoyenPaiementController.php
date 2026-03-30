<?php
// app/Http/Controllers/MoyenPaiementController.php

namespace App\Http\Controllers;

use App\Models\MoyenPaiement;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoyenPaiementController extends Controller
{
    /**
     * Affiche la liste des moyens de paiement
     */
    public function index(Request $request)
    {
        $query = MoyenPaiement::with('client');
        
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('numero', 'LIKE', "%{$request->search}%")
                  ->orWhereHas('client', function($clientQuery) use ($request) {
                      $clientQuery->where('nom', 'LIKE', "%{$request->search}%")
                                  ->orWhere('prenom', 'LIKE', "%{$request->search}%");
                  });
            });
        }
        
        if ($request->has('type')) {
            $query->where('type_moyen', $request->type);
        }
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $moyens = $query->latest()->paginate(20);
        
        // Statistiques
        $stats = [
            'total' => MoyenPaiement::count(),
            'cartes' => MoyenPaiement::where('type_moyen', 'carte')->count(),
            'chequiers' => MoyenPaiement::where('type_moyen', 'chequier')->count(),
            'virements' => MoyenPaiement::where('type_moyen', 'virement_permanent')->count(),
            'actifs' => MoyenPaiement::where('statut', 'actif')->count(),
            'expires' => MoyenPaiement::where('statut', 'expire')->count(),
        ];
        
        return view('moyens-paiement.index', compact('moyens', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $clients = Client::where('statut', 'actif')->get();
        return view('moyens-paiement.create', compact('clients'));
    }

    /**
     * Enregistre un nouveau moyen de paiement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id_client',
            'type_moyen' => 'required|in:carte,chequier,virement_permanent',
            'numero' => 'nullable|required_if:type_moyen,carte|unique:moyens_paiement,numero',
            'date_expiration' => 'nullable|required_if:type_moyen,carte|date|after:today'
        ]);

        DB::transaction(function() use ($validated) {
            MoyenPaiement::create([
                'type_moyen' => $validated['type_moyen'],
                'numero' => $validated['numero'] ?? $this->genererNumero($validated['type_moyen']),
                'date_emission' => now(),
                'date_expiration' => $validated['date_expiration'] ?? now()->addYears(3),
                'statut' => 'actif',
                'id_client' => $validated['id_client']
            ]);
        });

        return redirect()->route('moyens-paiement.index')
                        ->with('success', 'Moyen de paiement ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un moyen de paiement
     */
    public function show(MoyenPaiement $moyensPaiement)
    {
        $moyensPaiement->load('client');
        return view('moyens-paiement.show', compact('moyensPaiement'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(MoyenPaiement $moyensPaiement)
    {
        return view('moyens-paiement.edit', compact('moyensPaiement'));
    }

    /**
     * Met à jour un moyen de paiement
     */
    public function update(Request $request, MoyenPaiement $moyensPaiement)
    {
        $validated = $request->validate([
            'statut' => 'required|in:actif,bloque,expire,en_attente'
        ]);

        $moyensPaiement->update($validated);

        return redirect()->route('moyens-paiement.show', $moyensPaiement)
                        ->with('success', 'Moyen de paiement mis à jour avec succès.');
    }

    /**
     * Bloquer un moyen de paiement
     */
    public function bloquer(MoyenPaiement $moyensPaiement)
    {
        $moyensPaiement->update(['statut' => 'bloque']);
        
        return redirect()->back()
                        ->with('success', 'Moyen de paiement bloqué avec succès.');
    }

    /**
     * Activer un moyen de paiement
     */
    public function activer(MoyenPaiement $moyensPaiement)
    {
        $moyensPaiement->update(['statut' => 'actif']);
        
        return redirect()->back()
                        ->with('success', 'Moyen de paiement activé avec succès.');
    }

    /**
     * Générer un numéro selon le type
     */
    private function genererNumero($type)
    {
        switch($type) {
            case 'carte':
                return '**** **** **** ' . rand(1000, 9999);
            case 'chequier':
                return 'CHQ-' . date('Y') . '-' . rand(1000, 9999);
            case 'virement_permanent':
                return 'VIR-' . date('Ymd') . '-' . rand(100, 999);
            default:
                return 'MP-' . time();
        }
    }
}