<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Doctrine\ORM\TransactionMiddleware;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Logger\Formatter\ClassNameFormatter;
use League\Tactician\Logger\Formatter\Formatter;
use League\Tactician\Logger\LoggerMiddleware;
use Psr\Container\ContainerInterface;
use TheRestartProject\RepairDirectory\Application\Tactician\LaravelContainerAdapter;

class TacticianServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->handlerMiddleware();
        $this->loggerMiddleware();
        $this->doctrineMiddleware();

        $this->app->singleton(CommandBus::class, function(Application $app) {
            return new CommandBus([
                $app->make(LoggerMiddleware::class),
                $app->make(TransactionMiddleware::class),
                $app->make(CommandHandlerMiddleware::class)
            ]);
        });
    }

    public function handlerMiddleware()
    {
        $this->app->singleton(HandlerLocator::class, function ($app) {
            return new ContainerLocator(
                new LaravelContainerAdapter($app),
                app('config')->get('tactician.handlers', [])
            );
        });

        $this->app->singleton(CommandNameExtractor::class, ClassNameExtractor::class);
        $this->app->singleton(MethodNameInflector::class, HandleInflector::class);
        $this->app->singleton(CommandHandlerMiddleware::class, CommandHandlerMiddleware::class);
    }

    public function loggerMiddleware()
    {
//Setting up Logger middleware
        $this->app->singleton(Formatter::class, ClassNameFormatter::class);
        $this->app->singleton(LoggerMiddleware::class, LoggerMiddleware::class);
    }

    public function doctrineMiddleware()
    {
        $this->app->singleton(TransactionMiddleware::class, TransactionMiddleware::class);
    }
}
