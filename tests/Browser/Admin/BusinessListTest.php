<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Admin;

use Illuminate\Contracts\Auth\Authenticatable;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\BusinessListPage;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\MapPage;

/**
 * Test class for the Admin Business list functionality
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class BusinessListTest extends DuskTestCase
{
    use DatabaseMigrations, FixometerDatabaseMigrations;
    /**
     * Test that I need to be logged in to visit the admin page
     *
     * Given I am not logged in
     *  When I visit the admin page
     *  Then I should be redirected to the homepage
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_visit_the_admin_page_if_not_logged_in()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visitRoute('admin.index')
                    ->assertRouteIs('home');
            }
        );
    }

    /**
     * Test that a guest cannot visit the admin section
     *
     * Given I am logged in as a guest
     *  When I visit the admin page
     *  Then I should be redirected to the homepage
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_visit_the_admin_page_if_i_am_logged_in_as_a_guest()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::GUEST]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visitRoute('admin.index')
                    ->assertRouteIs('home');
            }
        );
    }

    /**
     * Test that searching in a location with no repair shops shows no results
     *
     * When I search in an area with no results
     * Then I should see a message telling me that there were 0 results nearby
     *
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
