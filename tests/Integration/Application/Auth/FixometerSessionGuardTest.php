<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Application\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionGuard;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Test for the FixometerSessionGuard
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class FixometerSessionGuardTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * It logs in an existing user
     *
     * @test
     *
     * @return void
     */
    public function it_can_login_an_existing_user()
    {
        /**
         * The Created user that implements Authenticable
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create();

        $this->guard()->login($user);

        $this->assertLoggedInAs($user);
    }

    /**
     * It can log out a logged in user
     *
     * @test
     *
     * @return void
     */
    public function it_can_log_out_a_logged_in_user()
    {
        /**
         * The Created user that implements Authenticable
         *
         * @var Authenticatable $user
         */
        $this->logInUser(entity(User::class)->create());

        $this->guard()->logout();

        self::assertNull($this->guard()->user());
    }

    /**
     * The guard from the application
     *
     * @return FixometerSessionGuard
     */
    protected function guard()
    {
        return $this->app->make('auth')->guard();
    }

    /**
     * Logs in the user through the guard
     *
     * @param Authenticatable $user The user to log in with
     *
     * @return $this
     */
    protected function logInUser(Authenticatable $user)
    {
        $this->guard()->login($user);

        return $this;
    }

    /**
     * Assert that the user has been logged in
     *
     * @param Authenticatable $user The user we are logged in as
     *
     * @return $this
     */
    protected function assertLoggedInAs(Authenticatable $user)
    {
        $loggedInUser = $this->guard()->user();

        self::assertInstanceOf(Authenticatable::class, $loggedInUser);
        self::assertEquals($user->getAuthIdentifier(), $loggedInUser->getAuthIdentifier());

        return $this;
    }
}
