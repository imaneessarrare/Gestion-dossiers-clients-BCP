<?php
// app/Http/Controllers/ExportController.php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\Credit;
use App\Models\Impaye;
use App\Models\Operation;
use App\Exports\ClientsExport;
use App\Exports\ComptesExport;
use App\Exports\CreditsExport;
use App\Exports\ImpayesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // ==================== EXPORT EXCEL ====================

    public function exportClientsExcel(Request $request)
    {
        $query = Client::query();
        
        if ($request->has('search')) {
            $query->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('prenom', 'like', "%{$request->search}%")
                  ->orWhere('cin', 'like', "%{$request->search}%");
        }
        
        $clients = $query->get();
        
        activity()
            ->causedBy(auth()->user())
            ->log('Export Excel de la liste des clients');
            
        return Excel::download(new ClientsExport($clients), 'clients_' . date('Y-m-d') . '.xlsx');
    }

    public function exportComptesExcel(Request $request)
    {
        $query = Compte::with('client');
        
        if ($request->has('type')) {
            $query->where('type_compte', $request->type);
        }
        
        $comptes = $query->get();
        
        activity()
            ->causedBy(auth()->user())
            ->log('Export Excel de la liste des comptes');
            
        return Excel::download(new ComptesExport($comptes), 'comptes_' . date('Y-m-d') . '.xlsx');
    }

    public function exportCreditsExcel(Request $request)
    {
        $query = Credit::with('client');
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $credits = $query->get();
        
        activity()
            ->causedBy(auth()->user())
            ->log('Export Excel de la liste des crédits');
            
        return Excel::download(new CreditsExport($credits), 'credits_' . date('Y-m-d') . '.xlsx');
    }

    public function exportImpayesExcel(Request $request)
    {
        $query = Impaye::with('client');
        
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $impayes = $query->get();
        
        activity()
            ->causedBy(auth()->user())
            ->log('Export Excel de la liste des impayés');
            
        return Excel::download(new ImpayesExport($impayes), 'impayes_' . date('Y-m-d') . '.xlsx');
    }

    // ==================== EXPORT PDF ====================

    public function exportClientPdf($id)
    {
        $client = Client::with(['comptes', 'credits', 'impayes'])->findOrFail($id);
        
        $pdf = Pdf::loadView('exports.client-pdf', compact('client'));
        
        activity()
            ->causedBy(auth()->user())
            ->performedOn($client)
            ->log('Export PDF de la fiche client');
            
        return $pdf->download('client_' . $client->nom . '_' . $client->prenom . '.pdf');
    }

    public function exportReleveComptePdf($id, Request $request)
    {
        $compte = Compte::with('client')->findOrFail($id);
        
        $mois = $request->get('mois', now()->month);
        $annee = $request->get('annee', now()->year);
        
        $operations = $compte->operations()
            ->whereYear('date_operation', $annee)
            ->whereMonth('date_operation', $mois)
            ->orderBy('date_operation')
            ->get();
        
        $pdf = Pdf::loadView('exports.releve-pdf', compact('compte', 'operations', 'mois', 'annee'));
        
        activity()
            ->causedBy(auth()->user())
            ->performedOn($compte)
            ->log("Export PDF du relevé de compte pour le mois $mois/$annee");
            
        return $pdf->download('releve_' . $compte->numero_compte . '_' . $mois . '_' . $annee . '.pdf');
    }

    public function exportEcheancesCreditPdf($id)
    {
        $credit = Credit::with(['client', 'echeances'])->findOrFail($id);
        
        $pdf = Pdf::loadView('exports.echeances-pdf', compact('credit'));
        
        activity()
            ->causedBy(auth()->user())
            ->performedOn($credit)
            ->log('Export PDF du tableau des échéances');
            
        return $pdf->download('echeances_credit_' . $credit->id_credit . '.pdf');
    }

    public function exportStatistiquesPdf(Request $request)
    {
        $stats = [
            'clients' => Client::count(),
            'clients_actifs' => Client::where('statut', 'actif')->count(),
            'comptes' => Compte::count(),
            'comptes_actifs' => Compte::where('statut', 'actif')->count(),
            'credits' => Credit::count(),
            'credits_encours' => Credit::whereIn('statut', ['en_cours', 'en_retard'])->count(),
            'impayes' => Impaye::count(),
            'impayes_montant' => Impaye::sum('montant'),
        ];
        
        $pdf = Pdf::loadView('exports.statistiques-pdf', compact('stats'));
        
        activity()
            ->causedBy(auth()->user())
            ->log('Export PDF des statistiques globales');
            
        return $pdf->download('statistiques_' . date('Y-m-d') . '.pdf');
    }
}