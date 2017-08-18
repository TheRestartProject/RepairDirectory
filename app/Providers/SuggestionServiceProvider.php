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
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Application\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Domain\Repositories\SuggestionRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineBusinessRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories\DoctrineSuggestionRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Types\PointType;

class SuggestionServiceProvider extends ServiceProvider
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
        $this->app->singleton(SuggestionRepository::class, DoctrineSuggestionRepository::class);
    }

}
