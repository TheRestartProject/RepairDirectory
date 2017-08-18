<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Class HomePage
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class HomePage extends Page
{
    const NO_RESULTS = '0 results in your area';


    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser The browser object to run tests with
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertRouteIs('map');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@searchByLocation' => 'input[name=location]',
            '@filterByCategory' => 'input[name=category]',
            '@submitButton' => 'button#submit',
            '@businessList' => '#business-list-container > ul',
            '@businesses' => '#business-list-container > ul > li',
        ];
    }

    public function assertNoResults(Browser $browser)
    {
        $browser->assertSee(self::NO_RESULTS);
    }
}
