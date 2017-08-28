<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:21
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JonnyW\PhantomJs\Client;

class PhantomServiceProvider extends ServiceProvider
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
        $this->app->singleton(Client::class, function () {
            $phantom = Client::getInstance();
            $phantom->isLazy();
            $phantom->getEngine()->setPath(config('phantom.path'));
            return $phantom;
        });
    }

}
