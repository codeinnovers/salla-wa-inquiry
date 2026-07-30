<?php
namespace Mega\SallaVoiceAI\Providers;

use Illuminate\Support\ServiceProvider;

class SallaVoiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../../config/salla-ai.php' => config_path('salla-ai.php'),
        ], 'config');
    }
}