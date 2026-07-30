<?php

use Illuminate\Support\Facades\Route;
use Maize\MagicLogin\Facades\MagicLink;

Route::view('/', 'social');




Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

MagicLink::route();
Route::get('magic-link',[\App\Http\Controllers\Users\LoginController::class,'sendLoginLink'])->name('customer.magic-link');

Route::get('redirect', [\App\Http\Controllers\InstallationController::class, 'redirect']);
Route::get('callback', [\App\Http\Controllers\InstallationController::class, 'callback']);
Route::post('index', [\App\Http\Controllers\InstallationController::class, 'index']);