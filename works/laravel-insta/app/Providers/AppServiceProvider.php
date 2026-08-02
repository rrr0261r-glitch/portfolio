<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // to use bootstrap css

        //Gates
        //          (name      function)
        Gate::define('admin', function($user){
            return $user->role_id === user::ADMIN_ROLE_ID;
        });
    }
}
