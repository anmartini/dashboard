<?php

namespace App\Services\Arpa;

use Illuminate\Support\ServiceProvider;

class ArpaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ArpaApi::class, function () {
            return new ArpaApi();
        });
    }
}
