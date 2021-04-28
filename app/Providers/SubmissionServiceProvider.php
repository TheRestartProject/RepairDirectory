<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:21
 */

namespace App\Providers;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\ServiceProvider;
use TheRestartProject\RepairDirectory\Application\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Domain\Repositories\SubmissionRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineSubmissionRepository;

class SubmissionServiceProvider extends ServiceProvider
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
        $this->app->singleton(SubmissionRepository::class, DoctrineSubmissionRepository::class);
    }
}
