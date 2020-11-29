<?php

use App\Http\Controllers\App\Dashboard\AcademicDashboardController;
use App\Http\Controllers\App\Dashboard\DashboardController;
use App\Http\Controllers\App\Dashboard\EcommerceDashboardController;
use App\Http\Controllers\App\Dashboard\HospitalDashboardController;
use App\Http\Controllers\App\Dashboard\HrmDashboardController;

Route::group(['prefix' => 'dashboard'], function(){
    Route::view('/pannes', 'dashboard.pannes');
    Route::view('/transactions', 'dashboard.trans');
    Route::view('/abonnements', 'dashboard.abonns');
    Route::view('/revendeur', 'dashboard.revendeur');
    Route::view('/settings', 'dashboard.settings');
});

// Default dashboard
Route::get('default-dashboard-abonnements', [DashboardController::class, 'abonnements']);
Route::get('default-dashboard-transactions', [DashboardController::class, 'transactions']);
Route::get('default-dashboard-pannesAbonnement', [DashboardController::class, 'pannesAbonnement']);
Route::get('default-dashboard-produits', [DashboardController::class, 'produits']);
Route::get('default-dashboard-pannes', [DashboardController::class, 'pannes']);
Route::get('default-dashboard-modalites', [DashboardController::class, 'modalites']);

Route::post('/revendeur', [DashboardController::class, 'store']);
Route::post('/pannes', [DashboardController::class, 'store']);
Route::post('/modalites', [DashboardController::class, 'store']);

