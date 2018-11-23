<?php

namespace TheRestartProject\RepairDirectory\Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;

/**
 * Class DuskTestCase
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 *
 * @method runDatabaseMigrations
 * @method runFixometerDatabaseMigrations
 */
abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return      void
     */
    public static function prepare()
    {
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://selenium:4444/wd/hub',
            DesiredCapabilities::chrome()
        );
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
