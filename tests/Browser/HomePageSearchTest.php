<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser;

use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\HomePage;

class HomePageSearchTest extends DuskTestCase
{
    /**
     * assert that when I visit the homepage I can go there
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                    ->assertRouteIs('map')
                    ->assertSee('Your location')
                    ->assertSee('Category');
        });
    }

    /**
     * test that searching in a location with no repair shops shows no results
     *
     * When I search in an area with no results
     * Then I should see a message telling me that there were 0 results nearby
     *
     * @test
     *
     * @return void
     */
    public function if_search_for_a_location_with_no_repair_shops_there_should_be_no_results()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->type('@searchByLocation', 'romford')
                ->press('@submitButton', 10)
                ->waitForText('results in your area', 10)
                ->on(new HomePage())
                ->assertNoResults();

            $browser;
        });
    }
}
