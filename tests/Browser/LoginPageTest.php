<?php
namespace TheRestartProject\RepairMap\Tests\Browser;


use Laravel\Dusk\Browser;
use PDepend\Util\Log;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\LoginPage;

class LoginPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function i_cannot_login_to_an_account_that_doesnt_exist()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage())
                ->assertMissing('.alert.alert-danger')
                ->type('email', 'test@user.com')
                ->type('password', 'password')
                ->press('button')
                ->assertLoginFailed();
        });
    }

    /**
     * @test
     */
    public function i_cannot_login_to_an_existing_account_with_the_wrong_password()
    {
        $user = entity(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new LoginPage())
                ->type('email', $user->getEmail())
                ->type('password', 'wrongpassword')
                ->press('button')
                ->assertLoginFailed();
        });
    }

    /**
     * @test
     */
    public function i_can_log_into_an_account_with_the_correct_password()
    {
        $user = entity(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new LoginPage())
                ->type('email', $user->getEmail())
                ->type('password', 'secret')
                ->press('button')
                ->assertLoginSucceededAs($user);
        });
    }
}