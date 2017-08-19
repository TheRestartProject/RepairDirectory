<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;


use Laravel\Dusk\Browser;

class LoginPage extends Page
{

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser The browser object to run tests with
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertRouteIs('login');
    }

    public function assertLoginFailed(Browser $browser)
    {
        $browser->assertRouteIs('login')
            ->assertVisible('.alert.alert-danger');

        return $this;
    }

    public function assertLoginSucceededAs(Browser $browser, $user)
    {
        $browser->assertRouteIs('map')
            ->assertAuthenticatedAs($user);

        return $this;
    }

    public function login(Browser $browser, $email, $password = 'secret')
    {
        $browser->type('email', $email)
        ->type('password', $password);

        return $this;
    }
}