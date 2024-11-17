<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

// ROTAS DA API FICARÁ DENTRO DESTE BLOCO

//customers
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

// cart
Route::resource('/cart', CartController::class)->only(['index', 'store', 'destroy', 'show']);

// cartItens
Route::resource('/cartItens', CartItemController::class)->only(['index', 'store']);
Route::get('/cartItens/{idCart}/{idProduct}', [CartItemController::class, 'show']);
Route::put('/cartItens-quantity/{idCart}/{idProduct}', [CartItemController::class, 'updateQuantity']);
Route::put('/cartItens-add-item/{idCart}/{idProduct}', [CartItemController::class, 'updateAddItem']);
Route::delete('/cartItens/{idCart}/{idProduct}', [CartItemController::class, 'destroy']);

// orders
Route::resource('/orders', OrderController::class)->only(['index', 'store', 'destroy', 'show', 'update']);
Route::put('/orders-status/{id}', [OrderController::class, 'updateStatus']);

// ordersItens
Route::resource('/orderItens', OrderItemController::class)->only(['index', 'store']);
Route::get('/orderItens/{idOrder}', [OrderItemController::class, 'show']);
Route::get('/orderItens-itens/{idOrder}/{idProduct}', [OrderItemController::class, 'showItens']);
Route::put('/orderItens-quantity/{idOrder}/{idProduct}', [OrderItemController::class, 'updateQuantity']);
Route::put('/orderItens-add-item/{idOrder}/{idProduct}', [OrderItemController::class, 'updateAddItem']);
Route::delete('/orderItens/{idOrder}/{idProduct}', [OrderItemController::class, 'destroy']);