<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Credit;
use App\Models\Impaye;
use App\Models\Operation;
use App\Models\MoyenPaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal
     */
    public function index()
    {
        // ========== STATISTIQUES GÉNÉRALES (mise en cache) ==========
        $stats = Cache::remember('dashboard_stats', 60, function () {
            return [
                'clients_actifs' => Client::where('statut', 'actif')->count(),
                'clients_total' => Client::count(),
                'comptes_actifs' => Compte::where('statut', 'actif')->count(),
                'comptes_total' => Compte::count(),
                'credits_encours' => Credit::whereIn('statut', ['en_cours', 'en_retard'])->count(),
                'credits_total' => Credit::count(),
                'impayes_nouveaux' => Impaye::where('statut', 'nouveau')->count(),
                'impayes_total' => Impaye::whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->sum('montant'),
                'moyens_paiement' => MoyenPaiement::count(),
            ];
        });

        // ========== ÉVOLUTION DES CLIENTS (optimisée avec index) ==========
        $clientsEvolution = Cache::remember('clients_evolution_30', 60, function () {
            return Client::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        });

        // ========== TOP 5 CLIENTS À RISQUE (optimisé) ==========
        $clientsRisques = Cache::remember('clients_risques', 30, function () {
            return Client::withCount(['impayes' => function($q) {
                    $q->whereIn('statut', ['nouveau', 'en_relance', 'contentieux']);
                }])
                ->with(['impayes' => function($q) {
                    $q->whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->limit(5);
                }])
                ->having('impayes_count', '>', 0)
                ->orderByDesc('impayes_count')
                ->limit(5)
                ->get();
        });

        // ========== DERNIÈRES OPÉRATIONS (limitées à 10) ==========
        $dernieresOperations = Operation::with('compte.client')
            ->latest('date_operation')
            ->limit(10)
            ->get();

        // ========== RÉPARTITION DES COMPTES ==========
        $repartitionComptes = Cache::remember('repartition_comptes', 60, function () {
            return [
                'courant' => Compte::where('type_compte', 'courant')->count(),
                'epargne' => Compte::where('type_compte', 'epargne')->count(),
                'joint' => Compte::where('type_compte', 'joint')->count(),
            ];
        });

        // ========== CRÉDITS PAR STATUT ==========
        $creditsParStatut = Cache::remember('credits_par_statut', 60, function () {
            return [
                'en_cours' => Credit::where('statut', 'en_cours')->count(),
                'en_retard' => Credit::where('statut', 'en_retard')->count(),
                'rembourse' => Credit::where('statut', 'rembourse')->count(),
            ];
        });

        // ========== IMPAYÉS PAR STATUT ==========
        $impayesParStatut = Cache::remember('impayes_par_statut', 60, function () {
            return [
                'nouveau' => Impaye::where('statut', 'nouveau')->count(),
                'en_relance' => Impaye::where('statut', 'en_relance')->count(),
                'contentieux' => Impaye::where('statut', 'contentieux')->count(),
            ];
        });

        // ========== ALERTES ==========
        $alertes = [
            'echeances_proches' => Credit::whereHas('echeances', function($q) {
                $q->where('date_echeance', '<=', now()->addDays(7))
                  ->where('date_echeance', '>=', now())
                  ->where('statut_paiement', 'en_attente');
            })->count(),
            
            'impayes_nouveaux' => Impaye::where('statut', 'nouveau')->count(),
        ];

        return view('dashboard', compact(
            'stats',
            'clientsEvolution',
            'clientsRisques',
            'dernieresOperations',
            'repartitionComptes',
            'creditsParStatut',
            'impayesParStatut',
            'alertes'
        ));
    }

    /**
     * Affiche la page des statistiques détaillées
     */
    public function statistiques(Request $request)
    {
        $periode = $request->get('periode', 30);
        $dateDebut = now()->subDays($periode)->startOfDay();
        
        // Statistiques des crédits
        $credits = Credit::select(
            DB::raw('DATE(date_debut) as date'),
            DB::raw('COUNT(*) as nombre'),
            DB::raw('SUM(montant) as montant_total')
        )
        ->where('date_debut', '>=', $dateDebut)
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->map(function($item) {
            $item->date = \Carbon\Carbon::parse($item->date)->format('d/m');
            return $item;
        });
        
        // Statistiques des clients
        $clients = Client::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as nouveaux')
        )
        ->where('created_at', '>=', $dateDebut)
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->map(function($item) {
            $item->date = \Carbon\Carbon::parse($item->date)->format('d/m');
            return $item;
        });
        
        // Statistiques des opérations
        $operations = Operation::select(
            DB::raw('DATE(date_operation) as date'),
            'type_operation',
            DB::raw('COUNT(*) as nombre'),
            DB::raw('SUM(montant) as montant_total')
        )
        ->where('date_operation', '>=', $dateDebut)
        ->groupBy('date', 'type_operation')
        ->orderBy('date')
        ->get()
        ->groupBy('date');
        
        // Si les données sont vides, créer des données de démonstration
        if ($credits->isEmpty()) {
            $credits = $this->getDemoCreditsData($periode);
        }
        
        if ($clients->isEmpty()) {
            $clients = $this->getDemoClientsData($periode);
        }
        
        if ($operations->isEmpty()) {
            $operations = $this->getDemoOperationsData($periode);
        }
        
        $stats = [
            'credits' => $credits,
            'clients' => $clients,
            'operations' => $operations
        ];
        
        if ($request->ajax()) {
            return response()->json($stats);
        }
        
        return view('statistiques', compact('stats', 'periode'));
    }

    /**
     * Génère des données de démonstration pour les crédits
     */
    private function getDemoCreditsData($periode)
    {
        $data = [];
        for ($i = $periode; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('d/m');
            $data[] = (object)[
                'date' => $date,
                'nombre' => rand(1, 5),
                'montant_total' => rand(10000, 100000)
            ];
        }
        return collect($data);
    }

    /**
     * Génère des données de démonstration pour les clients
     */
    private function getDemoClientsData($periode)
    {
        $data = [];
        for ($i = $periode; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('d/m');
            $data[] = (object)[
                'date' => $date,
                'nouveaux' => rand(0, 3)
            ];
        }
        return collect($data);
    }

    /**
     * Génère des données de démonstration pour les opérations
     */
    private function getDemoOperationsData($periode)
    {
        $operations = [];
        for ($i = $periode; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $operations[$date] = collect([
                (object)['type_operation' => 'depot', 'montant_total' => rand(5000, 20000)],
                (object)['type_operation' => 'retrait', 'montant_total' => rand(2000, 15000)],
                (object)['type_operation' => 'virement', 'montant_total' => rand(1000, 10000)]
            ]);
        }
        return $operations;
    }

    /**
     * Exporte les données au format PDF/Excel
     */
    public function export($type)
    {
        switch($type) {
            case 'clients':
                $data = Client::with('comptes')->get();
                $filename = 'clients_' . now()->format('Y-m-d') . '.xlsx';
                $message = 'Export des clients en cours de développement';
                break;
            case 'impayes':
                $data = Impaye::with('client')->whereIn('statut', ['nouveau', 'en_relance', 'contentieux'])->get();
                $filename = 'impayes_' . now()->format('Y-m-d') . '.xlsx';
                $message = 'Export des impayés en cours de développement';
                break;
            case 'credits':
                $data = Credit::with('client')->whereIn('statut', ['en_cours', 'en_retard'])->get();
                $filename = 'credits_' . now()->format('Y-m-d') . '.xlsx';
                $message = 'Export des crédits en cours de développement';
                break;
            default:
                abort(404);
        }
        
        return back()->with('info', $message);
    }
}