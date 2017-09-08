<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Page class that represents the HomePage
 *
 * @category Page
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class HomePage extends Page
{
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
        $browser->assertRouteIs('home');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@mapButton' => 'a#map',
            '@userSelector' => 'form#login-as-user select',
            '@loginButton' => '#login',
            '@logoutButton' => '#logout',
        ];
    }
}
