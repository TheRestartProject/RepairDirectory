<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature;

use Illuminate\Support\Facades\Artisan;
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
 */
abstract class FeatureTestCase extends TestCase
{

    /**
     * Run the database migrations to prepare for use.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Artisan::call('doctrine:migrations:migrate');
    }

    /**
     * Rollback the database migrations so tests are idempotent.
     *
     * @return void
     */
    public function tearDown()
    {
        Artisan::call('doctrine:migrations:reset');
        parent::tearDown();
    }

}
