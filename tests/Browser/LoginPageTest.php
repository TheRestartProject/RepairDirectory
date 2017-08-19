<?php
namespace TheRestartProject\RepairMap\Tests\Browser;


use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\LoginPage;

class LoginPageTest extends DuskTestCase
{
    /**
     * @test
     */
    public function i_cannot_login_to_an_account_that_doesnt_exist()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage())
                ->type('email', 'test@user.com')
                ->type('password', 'password')
                ->assertRouteIs('login')
                ->assertVisible('.error');
        });
    }
}