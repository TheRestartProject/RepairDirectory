<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser;

use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\MapPage;

/**
 * Test class for the Search functionality on the map page
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class MapSearchTest extends DuskTestCase
{
    use DatabaseMigrations, FixometerDatabaseMigrations;
    /**
     * Assert that when I visit the homepage I can go there
     *
     * When I visit the MapPage
     * Then I should see the Location input
     * And I should see the Categories input
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_homepage()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit(new MapPage())
                    ->assertSee('Your location')
                    ->assertCategoryInputExists();
            }
        );
    }

    /**
     * Test that searching in a location with no repair shops shows no results
     *
     * When I search in an area with no results
     * Then I should see a message telling me that there were 0 results nearby
     *
     * todo: work out why this test isn't working
     *
     * @return void
     */
    public function if_i_search_for_a_location_with_no_repair_shops_there_should_be_no_results()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit(new MapPage())
                    ->type('@searchByLocation', 'romford')
                    ->press('@submitButton')
                    ->waitForText('results in your area', 10)
                    ->assertNoResults();
            }
        );
    }
}
