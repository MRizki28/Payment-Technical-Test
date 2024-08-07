<?php

use App\Http\Controllers\CMS\AuthController;
use App\Http\Controllers\CMS\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('v1/login', [AuthController::class, 'login']);

Route::middleware(['throttle:100,1', 'auth:api'])->group(function() {
    Route::prefix('v1')->group(function() {
        Route::prefix('transaction')->controller(TransactionController::class)->group(function() {
            Route::get('/', 'getDataHistoryTransaction');
            Route::post('create', 'createTransaction');
            Route::get('summary', 'getSummaryTransaction');
        });
    });
});