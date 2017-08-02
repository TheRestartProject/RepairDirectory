<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessGeocoder;
use TheRestartProject\RepairDirectory\Infrastructure\Services\BusinessGeocoderImpl;

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
        $this->app->singleton(BusinessGeocoder::class, function () {
            return new BusinessGeocoderImpl($this->app->make('geocoder'));
        });
    }
}