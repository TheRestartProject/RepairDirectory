<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SKAgarwal\GoogleApi\PlacesApi;

class LocationServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PlacesApi::class, function () {
            $key = config('google.places.key');
            return new PlacesApi($key);
        });
    }

}
