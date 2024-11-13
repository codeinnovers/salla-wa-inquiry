<?php
use Mega\SallaSocialShare\Http\Controllers\Salla\WebhooksController;
use Mega\SallaSocialShare\Http\Controllers\Salla\InquiryController;


Route::group(['prefix' => 'product-inquiry'],function (){
   Route::post('webhook',[WebhooksController::class,'index']);
    Route::post('whatsapp',[InquiryController::class,'inquiry']);
});


