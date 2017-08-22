<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser;

use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;

/**
 * Class HomePageTest
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Browser
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class HomePageTest extends DuskTestCase
{
    /**
     * Tests that a user can visit the homepage
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_homepage()
    {
        $this->browse(function(Browser $browser) {
            $browser->visit(new Pages\HomePage());
        });
    }
}