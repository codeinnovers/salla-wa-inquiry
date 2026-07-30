<?php

use Mega\StoreAndProductReviewsApp\Http\Controllers\WebhookController;
use Mega\StoreAndProductReviewsApp\Http\Controllers\ReviewController;

Route::group(['prefix' => 'store-and-product-reviews'], function () {
    Route::post('webhook',[WebhookController::class,'index']);
});


Route::group(['prefix' => 'api/product-reviews'],function (){
    Route::get('get-config', [ReviewController::class, 'getConfigValue']);
});