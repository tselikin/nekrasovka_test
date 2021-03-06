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

// Рубрики, на которые подписан подписчик
Route::get('/subscription/{subscriber}', [SubscriberController::class, 'subscriberSections'])->name('subscriberSections');

// Подписаться на рубрику
Route::post('/subscription', [SubscriberController::class, 'subscribe'])->name('subscribe');

// Отписаться от рубрики или от всех рубрик
Route::delete('/subscription', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');

// Получить подписчиков рубрики
Route::get('/{section}/subscribers', [SubscriberController::class, 'sectionSubscribers'])->name('sectionSubscribers');

// Аторизироваться по логину и паролю и получить api_token
Route::post('/app_login', [SubscriberController::class, 'getApiToken'])->name('getApiToken');

// Очистить api_token
Route::post('/app_logout', [SubscriberController::class, 'clearApiToken'])->name('clearApiToken');
