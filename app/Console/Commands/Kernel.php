<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Les commandes Artisan fournies par votre application.
     *
     * @var array
     */
    protected $commands = [
        // Enregistrement de votre commande de vérification des impayés
        \App\Console\Commands\VerifierImpayes::class,
    ];

    /**
     * Définir le planning des commandes.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Vérifier les impayés automatiquement chaque jour à 1h du matin
        $schedule->command('impayes:verifier')
                 ->dailyAt('01:00')
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/impayes.log'));
        
        // Alternative: Vérifier toutes les heures (pour les tests)
        // $schedule->command('impayes:verifier')->hourly();
        
        // Vérifier toutes les 30 minutes en production
        // $schedule->command('impayes:verifier')->everyThirtyMinutes();
    }

    /**
     * Enregistrer les commandes pour l'application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}