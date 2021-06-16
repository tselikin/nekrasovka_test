<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubscriberController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/subscription/{subscriber}', [SubscriberController::class, 'subscriberSections'])->name('subscriberSections');
Route::post('/subscription', [SubscriberController::class, 'subscribe'])->name('subscribe');
Route::delete('/subscription', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');


Route::post('/app_login', [SubscriberController::class, 'getApiToken'])->name('getApiToken');
Route::post('/app_logout', [SubscriberController::class, 'clearApiToken'])->name('clearApiToken');
