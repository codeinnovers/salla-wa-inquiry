<?php
namespace Mega\SallaSocialShare\Providers;
use Illuminate\Support\ServiceProvider;

class SallaSocialShareServiceProvider extends ServiceProvider
{


    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/route.php');

    }
}
