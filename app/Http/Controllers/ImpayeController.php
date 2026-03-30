<?php
// app/Http/Controllers/ImpayeController.php

namespace App\Http\Controllers;

use App\Models\Impaye;
use App\Models\Client;
use App\Models\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImpayeController extends Controller
{
    /**
     * Affiche la liste des impayés
     */
    public function index(Request $request)
    {
        $query = Impaye::with(['client', 'credit'])
                       ->whereIn('statut', ['nouveau', 'en_relance', 'contentieux']);
        
        if ($request->has('search')) {
            $query->whereHas('client', function($q) use ($request) {
                $q->where('nom', 'LIKE', "%{$request->search}%")
                  ->orWhere('prenom', 'LIKE', "%{$request->search}%");
            });
        }
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $impayes = $query->orderBy('date_impaye', 'desc')->paginate(20);
        
        // Statistiques
        $stats = [
            'total' => Impaye::whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->sum('montant'),
            'nombre' => Impaye::whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->count(),
            'moyenne' => Impaye::whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->avg('montant'),
            'par_statut' => Impaye::select('statut', DB::raw('COUNT(*) as total'))
                                   ->whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])
                                   ->groupBy('statut')
                                   ->pluck('total', 'statut')
        ];
        
        return view('impayes.index', compact('impayes', 'stats'));
    }

    /**
     * Affiche le formulaire de création d'un impayé
     */
    public function create()
    {
        $clients = Client::where('statut', 'actif')->get();
        return view('impayes.create', compact('clients'));
    }

    /**
     * Enregistre un nouvel impayé
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id_client',
            'montant' => 'required|numeric|min:0.01',
            'date_impaye' => 'required|date',
            'id_credit' => 'nullable|exists:credits,id_credit',
            'notes' => 'nullable|string'
        ]);

        Impaye::create([
            'montant' => $validated['montant'],
            'date_impaye' => $validated['date_impaye'],
            'statut' => 'nouveau',
            'id_client' => $validated['id_client'],
            'id_credit' => $validated['id_credit'] ?? null,
            'notes' => $validated['notes'] ?? null
        ]);

        return redirect()->route('impayes.index')
                        ->with('success', 'Nouvel impayé créé avec succès.');
    }

    /**
     * Affiche les détails d'un impayé
     */
    public function show(Impaye $impaye)
    {
        $impaye->load(['client', 'credit']);
        return view('impayes.show', compact('impaye'));
    }

    /**
     * Effectue une relance
     */
    public function relance(Impaye $impaye)
    {
        $impaye->update([
            'statut' => 'en_relance',
            'notes' => $impaye->notes . "\n" . now()->format('d/m/Y H:i') . " - Relance effectuée"
        ]);
        
        return redirect()->back()->with('success', 'Relance effectuée avec succès.');
    }

    /**
     * Résout un impayé
     */
    public function resoudre(Impaye $impaye)
    {
        $impaye->update(['statut' => 'resolu']);
        
        return redirect()->route('impayes.index')
                        ->with('success', 'Impayé marqué comme résolu.');
    }

    /**
     * Passe en contentieux
     */
    public function passageContentieux(Impaye $impaye)
    {
        $impaye->update(['statut' => 'contentieux']);
        
        return redirect()->back()
                        ->with('success', 'Impayé passé en contentieux.');
    }

    /**
     * Vérification manuelle des impayés
     */
    public function verifier()
    {
        \Artisan::call('impayes:verifier');
        return redirect()->back()
                        ->with('success', 'Vérification des impayés effectuée.');
    }
}