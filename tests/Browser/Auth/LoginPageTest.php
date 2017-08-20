<?php
namespace TheRestartProject\RepairMap\Tests\Browser\Auth;

use Illuminate\Auth\SessionGuard;
use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\LoginPage;

/**
 * Test class for the Login functionality
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class LoginPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * I cannot log into an account that doesn't exist
     *
     * Given no account exists
     * When I log in with credentials
     * Then my login attempt should have failed
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_login_into_an_account_that_doesnt_exist()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visit(new LoginPage())
                    ->assertMissing('.alert.alert-danger')
                    ->loginWithForm('test@user.com', 'wrongpassword')
                    ->assertLoginFailed();
            }
        );
    }

    /**
     * I cannot log into an existing account with the wrong password
     *
     * Given an account exists
     * When I log in with the correct email address
     * But I use the wrong password
     * Then my login attempt should have failed
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_login_to_an_existing_account_with_the_wrong_password()
    {
        $user = entity(User::class)->create();
        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->visit(new LoginPage())
                    ->loginWithForm($user->getEmail(), 'wrongpassword')
                    ->assertLoginFailed();
            }
        );
    }

    /**
     * I can log into an account with the correct password
     *
     * Given an account exists
     * When I log in with the correct credentials
     * Then I should successfuly be logged in
     *
     * @test
     *
     * @return void
     */
    public function i_can_log_into_an_account_with_the_correct_password()
    {
        $user = entity(User::class)->create();
        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->visit(new LoginPage())
                    ->loginWithForm($user->getEmail())
                    ->assertLoginSucceededAs($user);
            }
        );
    }

    /**
     * I can have my login session extended with a remember token
     *
     * Given an account exists
     * When I log in with the correct credentials
     *  And I check the remember me box
     * Then I should be successfully logged in
     *  And I should have a remember token
     *
     * @test
     *
     * @re
     */
    public function i_can_have_my_login_session_extended_with_the_remember_me_checkbox()
    {
        $user = entity(User::class)->create();
        $this->browse(
            function (Browser $browser) use ($user) {
                /** @var SessionGuard $guard */
                $browser->visit(new LoginPage())
                    ->loginWithForm($user->getEmail(), 'secret', true)
                    ->assertHasCookie($guard->getRecallerName());
            }
        );
    }
}