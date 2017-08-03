<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GeocoderImpl;

class GeocoderServiceProvider extends ServiceProvider
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
        $this->app->singleton(Geocoder::class, function () {
            return new GeocoderImpl($this->app->make('geocoder'));
        });
    }
}