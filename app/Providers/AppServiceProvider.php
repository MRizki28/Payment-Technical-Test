<?php

namespace App\Providers;

use App\Interfaces\AuthInterfaces;
use App\Interfaces\TransactionInterfaces;
use App\Repositories\AuthRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionInterfaces::class, TransactionRepositories::class);
        $this->app->bind(AuthInterfaces::class, AuthRepositories::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
