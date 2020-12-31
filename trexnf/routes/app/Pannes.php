<?php

use App\Http\Controllers\App\Dashboard\DashboardController;

Route::view('/declarePanne', 'panne.declarepanne');

Route::get('/declarePanne/email={email}/pdw={pdw}', [DashboardController::class, 'getAbonnement']);

Route::post('/declarePanne', [DashboardController::class, 'storePanneAbonnement']);