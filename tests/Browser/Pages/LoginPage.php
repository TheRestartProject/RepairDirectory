<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Pages;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Dusk\Browser;

/**
 * Represents the Login page as an object to assert behaviours against.
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
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

    /**
     * Assert that a login failed.
     *
     * If a login fails, the user should be redirected back to the login page,
     * and an error message should show.
     *
     * @param Browser $browser The browser to run tests with
     *
     * @return $this
     */
    public function assertLoginFailed(Browser $browser)
    {
        $browser->assertRouteIs('login')
            ->assertVisible('.alert.alert-danger');

        return $this;
    }

    /**
     * Asserts that the login succeeded and the given user is authenticated
     *
     * @param Browser         $browser The browser object to run tests with
     * @param Authenticatable $user    The user to check is authenticated
     *
     * @return $this
     */
    public function assertLoginSucceededAs(Browser $browser, $user)
    {
        $browser->assertRouteIs('map')
            ->assertAuthenticatedAs($user);

        return $this;
    }

    /**
     * Logs in the user with the given email address and password
     *
     * @param Browser $browser  The browser object to run tests with
     * @param string  $email    The email address to login with
     * @param string  $password The password to login with (default: secret)
     * @param bool    $remember Whether to tick the remember me checkbox
     *
     * @return $this
     */
    public function loginWithForm(Browser $browser, $email, $password = 'secret', $remember = false)
    {
        $browser->type('email', $email)
            ->type('password', $password);
        if ($remember) {
            $browser->check('remember');
        }

        $browser->press('button');

        return $this;
    }
}