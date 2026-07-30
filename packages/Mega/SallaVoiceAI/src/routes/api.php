<?php
use Illuminate\Support\Facades\Route;
use Mega\SallaVoiceAI\Controllers\VoiceController;
use Mega\SallaVoiceAI\Controllers\OAuthController;

Route::prefix('api')->group(function () {

    Route::post('/voice-search', [VoiceController::class, 'search']);
    Route::get('/install', [OAuthController::class, 'install']);
    Route::get('/callback', [OAuthController::class, 'callback']);

});