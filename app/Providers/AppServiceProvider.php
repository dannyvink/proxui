<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Proxmark3;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Proxmark3::class, function ($app) {
            return new Proxmark3(config('scanner.port'));
        });
    }
}
