<?php

namespace TheRestartProject\RepairDirectory\Tests;

use Illuminate\Contracts\Console\Kernel;

/**
 * Trait CreatesApplication
 *
 * @category Trait
 * @package  TheRestartProject\RepairDirectory\Tests
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = include __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
