<?php

use App\Http\Controllers\App\Dashboard\DashboardController;
use App\Http\Controllers\Core\CommuneController;
use App\Http\Controllers\Core\WilayaController;

Route::group(['prefix' => 'dashboard'], function(){
    Route::view('/pannes', 'dashboard.pannes');
    Route::view('/transactions', 'dashboard.trans');
    Route::view('/abonnements', 'dashboard.abonns');
    Route::view('/chargements', 'dashboard.chargements');
    Route::view('/revendeur', 'dashboard.revendeur');
    Route::view('/charge', 'dashboard.charge');
    Route::view('/settings', 'dashboard.settings');
});

// Default dashboard
Route::get('default-dashboard-abonnements', [DashboardController::class, 'abonnements']);
Route::get('default-dashboard-transactions', [DashboardController::class, 'transactions']);
Route::get('default-dashboard-pannesAbonnement', [DashboardController::class, 'pannesAbonnement']);
Route::get('default-dashboard-produits', [DashboardController::class, 'produits']);
Route::get('default-dashboard-pannes', [DashboardController::class, 'pannes']);
Route::get('default-dashboard-modalites', [DashboardController::class, 'modalites']);
Route::get('default-dashboard-comptes', [DashboardController::class, 'comptes']);
Route::get('default-dashboard-charges', [DashboardController::class, 'charges']);
Route::get('default-dashboard-wilayas', [WilayaController::class, 'getwilaya']);
Route::get('default-dashboard-communes/communget={code}', [CommuneController::class, 'getCommune']);
Route::get('/balance', [DashboardController::class, 'getBalance']);


Route::post('/revendeur', [DashboardController::class, 'store']);
Route::post('/pannes', [DashboardController::class, 'storePannes']);
Route::post('/modalites', [DashboardController::class, 'storeModalites']);
Route::post('/comptes', [DashboardController::class, 'storeComptes']);
Route::post('/produits', [DashboardController::class, 'storeProduit']);
Route::post('/charges', [DashboardController::class, 'storeCharge']);

Route::patch('/update-abonnement/{id}', [DashboardController::class, 'updateAbonnement']);
Route::patch('/update-transaction/{id}', [DashboardController::class, 'updateTransaction']);
Route::patch('/update-panne-abonnement/{id}', [DashboardController::class, 'updatePanneAbonnement']);
Route::patch('/update-panne/{id}', [DashboardController::class, 'updatePanne']);
Route::patch('/update-modalite/{id}', [DashboardController::class, 'updateModalite']);
Route::patch('/update-produit/{id}', [DashboardController::class, 'updateProduit']);
Route::patch('/update-charge/{id}', [DashboardController::class, 'updateCharge']);

Route::delete('/delete-abonnement/{id}', [DashboardController::class, 'deleteAbonnement']);
Route::delete('/delete-transaction/{id}', [DashboardController::class, 'deleteTransaction']);
Route::delete('/delete-panne-abonnement/{id}', [DashboardController::class, 'deletePanneAbonnement']);
Route::delete('/delete-panne/{id}', [DashboardController::class, 'deletePanne']);
Route::delete('/delete-modalite/{id}', [DashboardController::class, 'deleteModalite']);
Route::delete('/delete-produit/{id}', [DashboardController::class, 'deleteProduit']);
Route::delete('/delete-charge/{id}', [DashboardController::class, 'deleteCharge']);

