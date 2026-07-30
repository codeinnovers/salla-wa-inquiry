<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|--------------------------------------------------------------------------
*/

Route::post('/checkout/custom-data', [InstallationController::class, 'store']);
