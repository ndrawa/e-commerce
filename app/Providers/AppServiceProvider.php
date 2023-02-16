<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_SERVER') == 'kubernetes') {
            URL::forceScheme('https');
        }

        Blade::if('roles', function ($roles) {
            return Auth::check() && Auth::user()->hasRole($roles);
        });

        Blade::if('notrole', function ($roles) {
            return Auth::check() && !Auth::user()->hasRole($roles);
        });

        setlocale(LC_TIME, 'id_ID');
        \Carbon\Carbon::setLocale('id');
    }
}
