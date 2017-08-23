<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:21
 */

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
        $this->app->singleton(PlacesApi::class, function ($app) {
            $key = isset($app['config']['google.places.key'])
                ? $app['config']['google.places.key'] : null;

            return new PlacesApi($key);
        });
    }

}
