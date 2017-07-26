<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:21
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TheRestartProject\RepairDirectory\Domain\Services\Persister;
use TheRestartProject\RepairDirectory\Infrastructure\Services\DoctrinePersister;

class PersisterServiceProvider extends ServiceProvider
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
        $this->app->singleton(Persister::class, DoctrinePersister::class);
    }
}