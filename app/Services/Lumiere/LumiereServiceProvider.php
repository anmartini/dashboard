<?php

namespace App\Services\Lumiere;

use Illuminate\Support\ServiceProvider;

class LumiereServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LumiereApi::class, function () {
            return new LumiereApi();
        });
    }
}
