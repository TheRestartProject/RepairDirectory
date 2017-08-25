<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FixometerServiceProvider extends ServiceProvider
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
        $path = config('fixometer.path_to_fixometer_config');

        require_once base_path($path);
    }
}
