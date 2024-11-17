<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StockController;

// ROTAS DA API FICARÁ DENTRO DESTE BLOCO

//customers
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

// carts
Route::get('/carts', function (Request $request) {
    return 'teste';
});
Route::post('/carts', [CartController::class, 'store']);

// departments
Route::post('/departments', [DepartmentController::class, 'store']);
Route::get('/departments', [DepartmentController::class, 'index']);

//products
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);

//stocks
Route::put('/stocks/{id}', [StockController::class, 'update']);
Route::get('/stocks', [StockController::class, 'index']);