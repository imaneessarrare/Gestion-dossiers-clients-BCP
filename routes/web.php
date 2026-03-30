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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (Sans authentification)
|--------------------------------------------------------------------------
*/

// Page de connexion
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login');
// Routes d'export
Route::middleware(['auth'])->prefix('export')->name('export.')->group(function () {
    Route::get('/clients/excel', [App\Http\Controllers\ExportController::class, 'exportClientsExcel'])->name('clients.excel');
    Route::get('/comptes/excel', [App\Http\Controllers\ExportController::class, 'exportComptesExcel'])->name('comptes.excel');
    Route::get('/credits/excel', [App\Http\Controllers\ExportController::class, 'exportCreditsExcel'])->name('credits.excel');
    Route::get('/impayes/excel', [App\Http\Controllers\ExportController::class, 'exportImpayesExcel'])->name('impayes.excel');
    Route::get('/client/{id}/pdf', [App\Http\Controllers\ExportController::class, 'exportClientPdf'])->name('client.pdf');
    Route::get('/compte/{id}/releve-pdf', [App\Http\Controllers\ExportController::class, 'exportReleveComptePdf'])->name('releve.pdf');
    Route::get('/credit/{id}/echeances-pdf', [App\Http\Controllers\ExportController::class, 'exportEcheancesCreditPdf'])->name('echeances.pdf');
    Route::get('/statistiques/pdf', [App\Http\Controllers\ExportController::class, 'exportStatistiquesPdf'])->name('statistiques.pdf');
});
// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route de test
Route::get('/test', function () {
    return '✅ Laravel fonctionne correctement !';
});

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES (Authentification requise)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistiques', [DashboardController::class, 'statistiques'])->name('statistiques');
    Route::get('/export/{type}', [DashboardController::class, 'export'])->name('export');
    
    // ==================== GESTION DES CLIENTS ====================
    Route::resource('clients', ClientController::class);
    Route::get('/clients-search', [ClientController::class, 'search'])->name('clients.search');
    
    // ==================== GESTION DES COMPTES ====================
    Route::resource('comptes', CompteController::class);
    Route::get('/comptes/{compte}/operations', [CompteController::class, 'operations'])->name('comptes.operations');
    Route::post('/comptes/transfert', [CompteController::class, 'transfert'])->name('comptes.transfert');
    Route::get('/comptes/{compte}/releve', [CompteController::class, 'releve'])->name('comptes.releve');
    
    // ==================== GESTION DES CRÉDITS ====================
    Route::resource('credits', CreditController::class);
    Route::get('/credits/{credit}/echeances', [CreditController::class, 'echeances'])->name('credits.echeances');
    Route::post('/credits/echeance/{echeance}/paiement', [CreditController::class, 'paiementEcheance'])->name('credits.echeance.paiement');
    Route::post('/credits/simulation', [CreditController::class, 'simulation'])->name('credits.simulation');
    
    // ==================== GESTION DES IMPAYÉS ====================
    Route::resource('impayes', ImpayeController::class);
    Route::post('/impayes/{impaye}/relance', [ImpayeController::class, 'relance'])->name('impayes.relance');
    Route::post('/impayes/{impaye}/resoudre', [ImpayeController::class, 'resoudre'])->name('impayes.resoudre');
    Route::post('/impayes/{impaye}/contentieux', [ImpayeController::class, 'passageContentieux'])->name('impayes.contentieux');
    Route::post('/impayes/verifier', [ImpayeController::class, 'verifier'])->name('impayes.verifier');
    
    // ==================== GESTION DES MOYENS DE PAIEMENT ====================
    Route::resource('moyens-paiement', MoyenPaiementController::class);
    Route::post('/moyens-paiement/{moyen}/bloquer', [MoyenPaiementController::class, 'bloquer'])->name('moyens-paiement.bloquer');
    Route::post('/moyens-paiement/{moyen}/activer', [MoyenPaiementController::class, 'activer'])->name('moyens-paiement.activer');
    
    // ==================== GESTION DU PROFIL ====================
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    
    // ==================== PARAMÈTRES GÉNÉRAUX ====================
    Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::post('/parametres', [ParametreController::class, 'update'])->name('parametres.update');
    Route::post('/parametres/verifier-impayes', [ParametreController::class, 'verifierImpayes'])->name('parametres.verifier-impayes');
});

/*
|--------------------------------------------------------------------------
| ROUTES D'ADMINISTRATION (Réservées aux administrateurs)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Vérification du rôle admin dans le contrôleur
    Route::resource('utilisateurs', UtilisateurController::class);
});

/*
|--------------------------------------------------------------------------
| ROUTES API (Pour les appels AJAX)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/clients/recherche', [ClientController::class, 'apiSearch'])->name('clients.search');
    Route::get('/comptes/{client}/liste', [CompteController::class, 'apiListeParClient'])->name('comptes.par-client');
    Route::get('/stats/globales', [DashboardController::class, 'apiStats'])->name('stats.globales');
});
// ==================== GESTION DES IMPAYÉS ====================
Route::resource('impayes', ImpayeController::class);
Route::post('/impayes/{impaye}/relance', [ImpayeController::class, 'relance'])->name('impayes.relance');
Route::post('/impayes/{impaye}/resoudre', [ImpayeController::class, 'resoudre'])->name('impayes.resoudre');
Route::post('/impayes/{impaye}/contentieux', [ImpayeController::class, 'passageContentieux'])->name('impayes.contentieux');
Route::post('/impayes/verifier', [ImpayeController::class, 'verifier'])->name('impayes.verifier');
Route::get('/impayes/create', [ImpayeController::class, 'create'])->name('impayes.create'); // Déjà inclus dans resource
Route::post('/impayes', [ImpayeController::class, 'store'])->name('impayes.store'); // Déjà inclus dans resource
/*
|--------------------------------------------------------------------------
| ROUTE DE FALLBACK (404 personnalisée)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});