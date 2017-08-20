<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Application\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionGuard;
use TheRestartProject\RepairDirectory\Domain\Models\User;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

class FixometerSessionGuardTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * @test
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
     * @test
     */
    public function it_can_log_out_a_logged_in_user()
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
     * @return FixometerSessionGuard
     */
    protected function guard()
    {
        return $this->app->make('auth')->guard();
    }

    /**
     * @param $user
     */
    protected function assertLoggedInAs($user)
    {
        $loggedInUser = $this->guard()->user();

        self::assertInstanceOf(Authenticatable::class, $loggedInUser);
        self::assertEquals($user->getAuthIdentifier(), $loggedInUser->getAuthIdentifier());
    }
}
