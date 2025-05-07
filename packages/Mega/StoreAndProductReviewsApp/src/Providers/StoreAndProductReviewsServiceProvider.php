<?php

namespace Mega\StoreAndProductReviewsApp\Providers;

use Illuminate\Support\ServiceProvider;

class StoreAndProductReviewsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/route.php');
    }
    public function boot()
    {

    }
}
