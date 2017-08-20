<?php
namespace TheRestartProject\RepairMap\Tests\Browser\Auth;

use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;

/**
 * Test class for the logout functionality
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class LogoutPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * I get redirected if I try to log out when not logged in
     *
     * Given I am not logged in
     *  When I visit the logout page
     *  Then I should be redirected
     *
     * @test
     *
     * @return void
     */
    public function i_get_redirected_if_i_try_to_logout_when_not_logged_in()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit(route('logout'))
                    ->assertRouteIs('map');
            }
        );
    }

    /**
     * I can log out if I am logged in
     *
     * Given I am logged in
     *  When I visit the log out page
     *  Then I should not be logged in
     *   And I should be redirected
     *
     * @test
     *
     * @return void
     */
    public function i_can_logout_if_i_am_logged_in()
    {
        /**
         * A created user object that exists in the database
         *
         * @var User $user
         */
        $user = entity(User::class)->create();

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getUid())
                    ->assertAuthenticatedAs($user)
                    ->visit(route('logout'))
                    ->assertRouteIs('map');
            }
        );
    }
}