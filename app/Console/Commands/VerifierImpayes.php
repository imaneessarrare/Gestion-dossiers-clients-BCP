<?php
// app/Console/Commands/VerifierImpayes.php

namespace App\Console\Commands;

use App\Models\Credit;
use App\Models\Echeance;
use App\Models\Impaye;
use Illuminate\Console\Command;

class VerifierImpayes extends Command
{
    protected $signature = 'impayes:verifier';
    protected $description = 'Vérifie les échéances impayées et crée des impayés automatiquement';

    public function handle()
    {
        $this->info('Vérification des impayés en cours...');
        
        // Récupérer toutes les échéances en retard (date dépassée et non payées)
        $echeancesEnRetard = Echeance::where('date_echeance', '<', now())
                                     ->where('statut_paiement', 'en_attente')
                                     ->with('credit.client')
                                     ->get();
        
        $count = 0;
        
        foreach ($echeancesEnRetard as $echeance) {
            // Vérifier si un impayé existe déjà pour cette échéance
            $impayeExistant = Impaye::where('id_credit', $echeance->id_credit)
                                    ->where('date_impaye', $echeance->date_echeance)
                                    ->first();
            
            if (!$impayeExistant) {
                // Créer un nouvel impayé
                Impaye::create([
                    'montant' => $echeance->montant,
                    'date_impaye' => $echeance->date_echeance,
                    'statut' => 'nouveau',
                    'id_client' => $echeance->credit->id_client,
                    'id_credit' => $echeance->id_credit,
                    'notes' => 'Impayé généré automatiquement le ' . now()->format('d/m/Y')
                ]);
                
                // Mettre à jour le statut de l'échéance
                $echeance->update(['statut_paiement' => 'impaye']);
                
                // Mettre à jour le statut du crédit
                $echeance->credit->update(['statut' => 'en_retard']);
                
                $count++;
            }
        }
        
        $this->info("$count impayé(s) créé(s) automatiquement.");
        
        // Planifier la prochaine vérification
        return Command::SUCCESS;
    }
}