<?php

use Mega\StoreAndProductReviewsApp\Http\Controllers\WebhookController;

Route::group(['prefix' => 'store-and-product-reviews'], function () {
    Route::post('webhook',[WebhookController::class,'index']);
});
