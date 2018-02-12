<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Carbon::setLocale('it');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
