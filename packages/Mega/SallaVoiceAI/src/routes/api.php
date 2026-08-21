<?php
use Illuminate\Support\Facades\Route;
use Mega\SallaVoiceAI\Controllers\VoiceController;
use Mega\SallaVoiceAI\Controllers\OAuthController;
use Mega\SallaVoiceAI\Controllers\WebhookController;

Route::prefix('api')->group(function () {

    Route::post('/voice-search', [VoiceController::class, 'search']);
    Route::get('/salla-voice.js', [VoiceController::class, 'serveScript']);
    Route::get('/voice-search.js', [VoiceController::class, 'serveScript']);
    Route::get('/install', [OAuthController::class, 'install']);
    Route::get('/callback', [OAuthController::class, 'callback']);
    Route::post('/webhook', [WebhookController::class, 'index']);

});