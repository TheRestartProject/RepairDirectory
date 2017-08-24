<?php

namespace TheRestartProject\RepairDirectory\Testing;

use Illuminate\Contracts\Console\Kernel;

/**
 * A helpful trait that performs database migrations after every test
 *
 * @category Trait
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
trait FixometerDatabaseMigrations
{

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runFixometerDatabaseMigrations()
    {
        $this->artisan('doctrine:migrations:refresh', ['--connection' => 'fixometer']);

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(
            function () {
                $this->artisan('doctrine:migrations:reset', ['--connection'=> 'fixometer']);
            }
        );
    }

}