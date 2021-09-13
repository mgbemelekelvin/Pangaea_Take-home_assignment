<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('auth:api')->group(function () {

    //Create Subscription
    Route::post('/subscribe/{topic}', [\App\Http\Controllers\SubscriberController::class, 'store_api']);

    //Publish Message to Topic API Call
    Route::post('/publish/{topic}', [\App\Http\Controllers\MessageController::class, 'store_api']);

//});

