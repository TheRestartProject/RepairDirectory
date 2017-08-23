<?php

namespace App\Providers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionGuard;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionService;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineFixometerSessionRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('fixometer', function ($app, $name, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\Guard...

            return new FixometerSessionGuard(
                $name,
                Auth::createUserProvider($config['provider']),
                $app->make(FixometerSessionService::class)
            );
        });
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, DoctrineUserRepository::class);
        $this->app->singleton(FixometerSessionRepository::class, DoctrineFixometerSessionRepository::class);
        $this->app->singleton(FixometerSessionService::class, function($app) {
            return new FixometerSessionService(
                'PHPSESSID',
                $app->make(CommandBus::class),
                $app->make(FixometerSessionRepository::class)
            );
        });
    }
}
