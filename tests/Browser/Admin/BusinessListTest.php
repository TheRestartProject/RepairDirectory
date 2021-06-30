<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Admin;

use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\BusinessListPage;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use Laravel\Dusk\Browser;
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
                    ->assertRouteIs(RouteServiceProvider::HOME);
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
                    ->assertRouteIs(RouteServiceProvider::HOME);
            }
        );
    }

    /**
     * Tests that a restarter can visit the admin page
     *
     * Given I am logged in as a Restarter
     *  When I visit the admin page
     *  Then I should be on the admin page
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_admin_page_if_i_am_logged_in_as_a_restarter()
    {

        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visitRoute('admin.index')
                    ->assertRouteIs('admin.index');
            }
        );
    }
}
