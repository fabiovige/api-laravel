<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TesteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function(){

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('/invoices', InvoiceController::class);
        Route::apiResource('/users', UserController::class);
        Route::get('/teste', [TesteController::class, 'index']);

        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/verify', [AuthController::class, 'verify'])->name('verify');

    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

});

