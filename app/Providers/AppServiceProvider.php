<?php

namespace App\Providers;

use App\Repositories\Cart\CartEloquentORM;
use App\Repositories\Cart\CartItemEloquentORM;
use App\Repositories\Cart\CartItemRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Customer\CustomerEloquentORM;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Product\ProductEloquentORM;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Department\DepartmentEloquentORM;
use App\Repositories\Department\DepartmentRepositoryInterface;
use App\Repositories\Stock\StockEloquentORM;
use App\Repositories\Stock\StockRepositoryInterface;
use App\Repositories\Order\OrderEloquentORM;
use App\Repositories\Order\OrderItemEloquentORM;
use App\Repositories\Order\OrderItemRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerEloquentORM::class);
        $this->app->bind(CartRepositoryInterface::class, CartEloquentORM::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductEloquentORM::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentEloquentORM::class);
        $this->app->bind(StockRepositoryInterface::class, StockEloquentORM::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemEloquentORM::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderEloquentORM ::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemEloquentORM ::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
