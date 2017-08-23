<?php

namespace TheRestartProject\RepairDirectory\Tests;

use Illuminate\Support\Facades\Artisan;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class FeatureTestCase
 *
 * Superclass for all feature tests.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Feature
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @method runDatabaseMigrations
 * @method runFixometerDatabaseMigrations
 */
abstract class IntegrationTestCase extends TestCase
{

    /**
     * Run the database migrations to prepare for use.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[DatabaseMigrations::class])) {
            $this->runDatabaseMigrations();
        }

        if (isset($uses[FixometerDatabaseMigrations::class])) {
            $this->runFixometerDatabaseMigrations();
        }

        return $uses;
    }
}
