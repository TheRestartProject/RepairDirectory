<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:21
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TheRestartProject\RepairDirectory\Application\Authorizers\LaravelImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Application\Validators\CustomBusinessValidator;
use TheRestartProject\RepairDirectory\Domain\Authorizers\ImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineBusinessRepository;

class BusinessServiceProvider extends ServiceProvider
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
        $this->app->singleton(BusinessRepository::class, DoctrineBusinessRepository::class);
        $this->app->singleton(BusinessValidator::class, CustomBusinessValidator::class);
        $this->app->singleton(ImportBusinessAuthorizer::class, LaravelImportBusinessAuthorizer::class);
    }

}
