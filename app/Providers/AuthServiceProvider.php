<?php

namespace App\Providers;

use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionGuard;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionService;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineFixometerSessionRepository;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;
use TheRestartProject\RepairDirectory\Application\Auth\Policies\BusinessPolicy;
use TheRestartProject\RepairDirectory\Application\Auth\Policies\SubmissionsPolicy;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Submission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Business::class => BusinessPolicy::class,
        Submission::class => SubmissionsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Only users set with valid Repair Directory roles (via Restarters)
        // can access the admin section.
        Gate::define('accessAdmin', function ($user) {
            return $user->isSuperAdmin() || $user->isRegionalAdmin() || $user->isEditor();
        });

        Gate::define('assignRole', function ($user, $nameOfRoleToAssign) {
            // At present, only superadmins can assign any of the existing roles.
            // This will change when Editor role introduced.
            if ($user->isSuperAdmin())
                return true;

            return false;
        });

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
        $this->app->singleton(FixometerSessionService::class, function ($app) {
            return new FixometerSessionService(
                'PHPSESSID',
                $app->make(CommandBus::class),
                $app->make(FixometerSessionRepository::class),
                $app->make(CookieJar::class)
            );
        });
    }
}
