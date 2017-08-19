<?php
namespace TheRestartProject\RepairMap\Tests\Browser;


use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;

class LogoutPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function i_get_redirected_if_i_try_to_logout_when_not_logged_in()
    {
        /** @var User $user */
        $user = entity(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(route('logout'))
                ->assertRouteIs('map');
        });
    }

    /**
     * @test
     */
    public function i_can_logout_if_i_am_logged_in()
    {
        /** @var User $user */
        $user = entity(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->getUid())
                ->visit(route('logout'))
                ->assertRouteIs('map');
        });
    }
}