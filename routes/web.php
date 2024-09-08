<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

// ROTAS DA API FICARÁ DENTRO DESTE BLOCO
Route::prefix('api')->group(function () {
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    // Route::resource("/customers", CustomerController::class);
});
