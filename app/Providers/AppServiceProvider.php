<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
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
        View::composer('dashboard.*', function ($view) {
            $user = Auth::user();

            $userPermissions = $user->role_id ? $user->role->permissions->pluck('name')->toArray() : [];
            $isExternal = $user->user_type == 'external';

            $view->with([
                'userPermissions' => $userPermissions,
                'isExternal' => $isExternal,
            ]);
        });
        Paginator::useBootstrapFive();
    }
}
