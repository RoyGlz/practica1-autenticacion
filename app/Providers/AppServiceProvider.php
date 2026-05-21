<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('view-dashboard', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        Gate::define('edit-post', function ($user) {
            return $user->hasRole('admin') || $user->hasRole('editor');
        });

        Gate::define('delete-post', function ($user) {
            return $user->hasRole('admin');
        });
    }
}