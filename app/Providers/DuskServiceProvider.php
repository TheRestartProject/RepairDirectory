<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/_dusk/login/{userId}/{guard?}', 'TheRestartProject\RepairDirectory\Dusk\Http\Controllers\UserController@login')->middleware('web');

        Route::get('/_dusk/logout/{guard?}', 'TheRestartProject\RepairDirectory\Dusk\Http\Controllers\UserController@logout')->middleware('web');

        Route::get('/_dusk/user/{guard?}', 'TheRestartProject\RepairDirectory\Dusk\Http\Controllers\UserController@user')->middleware('web');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
