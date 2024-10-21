<?php

namespace App\Providers;

use App\Repositories\Cart\CartEloquentORM;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Customer\CustomerEloquentORM;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CustomerRepositoryInterface::class, CustomerEloquentORM::class);
        $this->app->bind(CartRepositoryInterface::class, CartEloquentORM::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
