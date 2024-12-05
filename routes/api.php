<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

// ROTAS DA API FICARÁ DENTRO DESTE BLOCO

// login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');

//customers
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers', [CustomerController::class, 'index'])->middleware(['auth:api','admin']);
Route::get('/customers/{id}', [CustomerController::class, 'show'])->middleware('auth:api');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->middleware('auth:api');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->middleware('admin');

// departments
Route::post('/departments', [DepartmentController::class, 'store'])->middleware('admin');
Route::get('/departments', [DepartmentController::class, 'index']);

//products
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);

//stocks
Route::put('/stocks/{id}', [StockController::class, 'update'])->middleware('admin');
Route::get('/stocks', [StockController::class, 'index']);

// cart
Route::resource('/cart', CartController::class)->only(['store', 'destroy', 'show']);
Route::get('/cart', [CartController::class, 'index'])->middleware(['auth:api', 'admin'])->name('cart.index');
// cartItens
Route::resource('/cartItens', CartItemController::class)->only(['index', 'store']);
Route::get('/cartItens/{idCart}/{idProduct}', [CartItemController::class, 'show']);
Route::put('/cartItens-quantity/{idCart}/{idProduct}', [CartItemController::class, 'updateQuantity']);
Route::put('/cartItens-add-item/{idCart}/{idProduct}', [CartItemController::class, 'updateAddItem']);
Route::delete('/cartItens/{idCart}/{idProduct}', [CartItemController::class, 'destroy']);

// orders
Route::middleware('auth:api')->group(function () {
    Route::resource('/orders', OrderController::class)->only(['index', 'store', 'destroy', 'show', 'update']);
    Route::put('/orders-status/{id}', [OrderController::class, 'updateStatus']);
});

// ordersItens
Route::middleware('auth:api')->group(function () {
    Route::resource('/orderItens', OrderItemController::class)->only(['index', 'store']);
    Route::get('/orderItens/{idOrder}', [OrderItemController::class, 'show'])->middleware('auth:api');
    Route::get('/orderItens-itens/{idOrder}/{idProduct}', [OrderItemController::class, 'showItens']);
    Route::put('/orderItens-quantity/{idOrder}/{idProduct}', [OrderItemController::class, 'updateQuantity']);
    Route::put('/orderItens-add-item/{idOrder}/{idProduct}', [OrderItemController::class, 'updateAddItem']);
    Route::delete('/orderItens/{idOrder}/{idProduct}', [OrderItemController::class, 'destroy']);
});