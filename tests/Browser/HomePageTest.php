<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser;

use Illuminate\Support\Collection;
use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\HomePage;
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
    use DatabaseMigrations;

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
            $browser->visit(new HomePage());
        });
    }

    /**
     * Tests that the user can click on a button and be taken to the map page
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_map_from_the_homepage()
    {
        $this->browse(function(Browser $browser) {
            $browser->visit(new HomePage())
                ->click('@mapButton')
                ->assertRouteIs('map');
        });
    }

    /**
     * Tests that the visitor can log in without a password to an existing user
     *
     * @test
     *
     * @return void
     */
    public function i_can_log_in_as_a_user_without_knowing_the_password()
    {
        /**
         * A collection of created users in the database
         *
         * @var Collection|User[] $users
         */
        $users = entity(User::class, 3)->create();

        $this->browse(function(Browser $browser) use ($users) {
            $user = $users->first();
            $browser->visit(new HomePage())
                ->select('@userSelector', $user->getUid())
                ->press('@loginButton', 5)
                ->assertRouteIs('map')
                ->assertAuthenticatedAs($user);
        });
    }
}