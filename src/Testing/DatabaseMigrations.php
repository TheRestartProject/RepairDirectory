<?php

namespace TheRestartProject\RepairDirectory\Testing;

use Illuminate\Contracts\Console\Kernel;

trait DatabaseMigrations
{

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('doctrine:migrations:refresh');

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('doctrine:migrations:reset');
        });
    }
}