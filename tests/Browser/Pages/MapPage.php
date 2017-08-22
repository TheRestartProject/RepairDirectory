<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Represents the Home page as an object to assert behaviours against.
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class MapPage extends Page
{
    const NO_RESULTS = '0 results in your area';


    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/map';
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

    /**
     * Asserts that there are no results on the page after a search
     *
     * When searching on the map, and there are no results, there should be
     * a message that tells the user that there are no results. This method
     * checks that this message is visible.
     *
     * @param Browser $browser The browser object to work with
     *
     * @return $this
     */
    public function assertNoResults(Browser $browser)
    {
        $browser->assertSee(self::NO_RESULTS);

        return $this;
    }

    /**
     * Asserts that the location input exists
     *
     * When on the map page, there should be an input box that allows the user to search
     * for a location to show businesses close to that location.
     *
     * @param Browser $browser The browser object to work with
     *
     * @return $this
     */
    public function assertLocationInputExists(Browser $browser)
    {
        $browser->assertSee('Your location');

        return $this;
    }

    /**
     * Asserts that the category input exists
     *
     * On the map page a user can choose one or more categories to filter
     * the list of businesses by. This asserts that this field exists.
     *
     * @param Browser $browser The browser object to work with
     *
     * @return $this
     */
    public function assertCategoryInputExists(Browser $browser)
    {
        $browser->assertSee('Categories');

        return $this;
    }
}
