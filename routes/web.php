<?php
// routes/web.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ImpayeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoyenPaiementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Page de connexion
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route de test
Route::get('/test', function () {
    return '✅ Laravel fonctionne correctement !';
});

// Route pour vider le cache (utile en production)
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache vidé avec succès !';
});

// Route pour forcer les migrations (utile si pas d'accès terminal)
Route::get('/run-migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return 'Migrations exécutées avec succès !';
});

// Diagnostic pour l'environnement
Route::get('/check-env', function () {
    return [
        'APP_URL' => config('app.url'),
        'APP_ENV' => config('app.env'),
        'SESSION_DRIVER' => config('session.driver'),
        'SESSION_SECURE' => config('session.secure'),
        'HTTPS' => request()->secure(),
        'REMOTE_ADDR' => request()->ip(),
        'HAS_APP_KEY' => !empty(config('app.key')),
        'CSRF_TOKEN' => csrf_token(),
    ];
});

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
    
    // Clients
    Route::resource('clients', ClientController::class);
    Route::get('/clients-search', [ClientController::class, 'search'])->name('clients.search');
    
    // Comptes
    Route::resource('comptes', CompteController::class);
    Route::get('/comptes/{compte}/operations', [CompteController::class, 'operations'])->name('comptes.operations');
    Route::post('/comptes/transfert', [CompteController::class, 'transfert'])->name('comptes.transfert');
    Route::get('/comptes/{compte}/releve', [CompteController::class, 'releve'])->name('comptes.releve');
    
    // Crédits
    Route::resource('credits', CreditController::class);
    Route::get('/credits/{credit}/echeances', [CreditController::class, 'echeances'])->name('credits.echeances');
    Route::post('/credits/echeance/{echeance}/paiement', [CreditController::class, 'paiementEcheance'])->name('credits.echeance.paiement');
    Route::post('/credits/simulation', [CreditController::class, 'simulation'])->name('credits.simulation');
    
    // Impayés (UNE SEULE FOIS)
    Route::resource('impayes', ImpayeController::class);
    Route::post('/impayes/{impaye}/relance', [ImpayeController::class, 'relance'])->name('impayes.relance');
    Route::post('/impayes/{impaye}/resoudre', [ImpayeController::class, 'resoudre'])->name('impayes.resoudre');
    Route::post('/impayes/{impaye}/contentieux', [ImpayeController::class, 'passageContentieux'])->name('impayes.contentieux');
    Route::post('/impayes/verifier', [ImpayeController::class, 'verifier'])->name('impayes.verifier');
    
    // Moyens de paiement
    Route::resource('moyens-paiement', MoyenPaiementController::class);
    Route::post('/moyens-paiement/{moyen}/bloquer', [MoyenPaiementController::class, 'bloquer'])->name('moyens-paiement.bloquer');
    Route::post('/moyens-paiement/{moyen}/activer', [MoyenPaiementController::class, 'activer'])->name('moyens-paiement.activer');
    
    // Profil
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    
    // Paramètres
    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::post('/parametres', [ParametreController::class, 'update'])->name('parametres.update');
    Route::post('/parametres/verifier-impayes', [ParametreController::class, 'verifierImpayes'])->name('parametres.verifier-impayes');
    
    // ==================== EXPORTS ====================
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/clients/excel', [ExportController::class, 'exportClientsExcel'])->name('clients.excel');
        Route::get('/comptes/excel', [ExportController::class, 'exportComptesExcel'])->name('comptes.excel');
        Route::get('/credits/excel', [ExportController::class, 'exportCreditsExcel'])->name('credits.excel');
        Route::get('/impayes/excel', [ExportController::class, 'exportImpayesExcel'])->name('impayes.excel');
        Route::get('/client/{id}/pdf', [ExportController::class, 'exportClientPdf'])->name('client.pdf');
        Route::get('/compte/{id}/releve-pdf', [ExportController::class, 'exportReleveComptePdf'])->name('releve.pdf');
        Route::get('/credit/{id}/echeances-pdf', [ExportController::class, 'exportEcheancesCreditPdf'])->name('echeances.pdf');
        Route::get('/statistiques/pdf', [ExportController::class, 'exportStatistiquesPdf'])->name('statistiques.pdf');
    });
});

/*
|--------------------------------------------------------------------------
| ROUTES ADMINISTRATION
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('utilisateurs', UtilisateurController::class);
});

/*
|--------------------------------------------------------------------------
| ROUTES API
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/clients/recherche', [ClientController::class, 'apiSearch'])->name('clients.search');
    Route::get('/comptes/{client}/liste', [CompteController::class, 'apiListeParClient'])->name('comptes.par-client');
    Route::get('/stats/globales', [DashboardController::class, 'apiStats'])->name('stats.globales');
});

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});