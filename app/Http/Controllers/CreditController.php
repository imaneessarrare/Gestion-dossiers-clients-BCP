<?php
// app/Http/Controllers/CreditController.php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Client;
use App\Models\Echeance;
use App\Models\Impaye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function index(Request $request)
    {
        $query = Credit::with('client');
        
        if ($request->has('search')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('nom', 'LIKE', "%{$request->search}%")
                  ->orWhere('prenom', 'LIKE', "%{$request->search}%");
            });
        }
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $credits = $query->latest()->paginate(20);
        
        // Statistiques
        $stats = [
            'total_encours' => Credit::enCours()->sum('montant'),
            'nombre_encours' => Credit::enCours()->count(),
            'en_retard' => Credit::enRetard()->count(),
            'taux_moyen' => Credit::enCours()->avg('taux_interet')
        ];
        
        return view('credits.index', compact('credits', 'stats'));
    }
    
    public function create()
    {
        $clients = Client::where('statut', 'actif')->get();
        return view('credits.create', compact('clients'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id_client',
            'montant' => 'required|numeric|min:1000',
            'taux_interet' => 'required|numeric|min:0|max:20',
            'duree_mois' => 'required|integer|min:6|max:360',
            'date_debut' => 'required|date'
        ]);
        
        DB::transaction(function() use ($validated) {
            $dateFin = date('Y-m-d', strtotime($validated['date_debut'] . " + {$validated['duree_mois']} months"));
            
            $credit = Credit::create([
                'montant' => $validated['montant'],
                'taux_interet' => $validated['taux_interet'],
                'duree_mois' => $validated['duree_mois'],
                'date_debut' => $validated['date_debut'],
                'date_fin' => $dateFin,
                'id_client' => $validated['id_client'],
                'statut' => 'en_cours'
            ]);
            
            // Générer les échéances
            $credit->genererEcheances();
        });
        
        return redirect()->route('credits.index')
                        ->with('success', 'Crédit accordé avec succès.');
    }
    
    public function show(Credit $credit)
    {
        $credit->load(['client', 'echeances' => function($q) {
            $q->orderBy('date_echeance');
        }]);
        
        return view('credits.show', compact('credit'));
    }
    
    public function echeances(Credit $credit)
    {
        $echeances = $credit->echeances()->orderBy('date_echeance')->get();
        
        return view('credits.echeances', compact('credit', 'echeances'));
    }
    
    public function paiementEcheance(Request $request, Echeance $echeance)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0.01'
        ]);
        
        DB::transaction(function() use ($echeance, $validated) {
            $echeance->marquerPayee();
            
            // Vérifier si c'est un impayé
            if ($echeance->date_echeance->isPast() && $echeance->statut_paiement === 'en_attente') {
                Impaye::where('id_credit', $echeance->id_credit)
                      ->where('date_impaye', $echeance->date_echeance)
                      ->update(['statut' => 'resolu']);
            }
        });
        
        return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
    }
    
    public function update(Request $request, Credit $credit)
    {
        $this->authorize('update', $credit);
        
        $validated = $request->validate([
            'statut' => 'required|in:en_cours,rembourse,en_retard,rejete'
        ]);
        
        $credit->update($validated);
        
        return redirect()->route('credits.show', $credit)
                        ->with('success', 'Statut du crédit mis à jour.');
    }
    
    public function simulation(Request $request)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:1000',
            'taux' => 'required|numeric|min:0|max:20',
            'duree' => 'required|integer|min:6|max:360'
        ]);
        
        $tauxMensuel = $validated['taux'] / 100 / 12;
        $mensualite = $validated['montant'] * $tauxMensuel * pow(1 + $tauxMensuel, $validated['duree']) / (pow(1 + $tauxMensuel, $validated['duree']) - 1);
        
        $total = $mensualite * $validated['duree'];
        $interets = $total - $validated['montant'];
        
        return response()->json([
            'mensualite' => round($mensualite, 2),
            'total' => round($total, 2),
            'interets' => round($interets, 2)
        ]);
    }
}