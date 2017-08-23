<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth;

use Illuminate\Support\Str;
use Ivory\HttpAdapter\Event\RequestErroredEvent;
use Mockery as m;
use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionService;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Tests for the FixometerSessionService
 *
 * @category
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class FixometerSessionServiceTest extends TestCase
{
    /**
     * Tests that it can get its own name
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_the_name_of_the_session()
    {
        $sessionName = 'test_session';

        $session = $this->createSession($sessionName);

        self::assertEquals($session->getName(), $sessionName);
    }

    /**
     * Tests that it returns an empty string if there is no cookie
     *
     * @test
     *
     * @return void
     */
    public function it_returns_an_empty_string_if_there_is_no_cookie()
    {
        $name = 'PHPSESSID';

        /**
         * A mocked Request object
         *
         * @var Request|m\MockInterface $request
         */
        $request = m::mock(Request::class);
        $request->shouldReceive('cookie')
            ->with($name, '')
            ->andReturn('');

        $session = $this->createSession($name, $request);

        $id = $session->getId();

        self::assertSame('', $id);
    }

    /**
     * Tests that it can get the session token from the cookie
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_the_token_of_the_session()
    {
        $token = Str::random(45);
        $name = 'PHPSESSID';

        /**
         * A mocked Request object
         *
         * @var Request|m\MockInterface $request
         */
        $request = m::mock(Request::class);
        $request->shouldReceive('cookie')
            ->with($name, '')
            ->andReturn($token);

        $session = $this->createSession($name, $request);

        $id = $session->getId();

        self::assertEquals($token, $id);
    }

    /**
     * Creates a session
     *
     * @param string       $name    The name of the session
     * @param Request|null $request The request object
     *
     * @return FixometerSessionService
     */
    protected function createSession($name = 'test', $request = null)
    {
        return new FixometerSessionService($name, $request);
    }
}
