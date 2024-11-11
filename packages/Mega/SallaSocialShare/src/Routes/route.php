<?php
use Mega\SallaSocialShare\Http\Controllers\Salla\WebhooksController;

Route::group(['prefix' => 'social-share'],function (){
   Route::post('webhook',[WebhooksController::class,'index']);
});


