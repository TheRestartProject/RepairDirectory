<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth;

use Illuminate\Support\Str;
use League\Tactician\CommandBus;
use Mockery as m;
use Hamcrest\Matchers as h;
use Illuminate\Http\Request;
use Psy\Command\Command;
use TheRestartProject\RepairDirectory\Application\Auth\FixometerSessionService;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Tests for the FixometerSessionService
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class FixometerSessionServiceTest extends TestCase
{
    const SESSION_NAME = 'PHPSESSID';

    /**
     * The mocked Request object
     *
     * @var Request|m\MockInterface
     */
    protected $request;

    /**
     * The mocked CommandBus
     *
     * @var CommandBus|m\MockInterface
     */
    protected $bus;

    /**
     * The mocked Repository
     *
     * @var FixometerSessionRepository|m\MockInterface
     */
    protected $repository;

    /**
     * Sets up the test environment
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->request = m::mock(Request::class);
        $this->bus = m::spy(CommandBus::class);
        $this->repository = m::spy(FixometerSessionRepository::class);
    }


    /**
     * Tests that it can get its own name
     *
     * @test
     *
     * @return void
     */
    public function it_can_get_the_name_of_the_session()
    {
        $session = $this->createSession();

        self::assertEquals($session->getName(), self::SESSION_NAME);
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
        $this->sessionGetsIdAndReturns('');

        $session = $this->createSession();

        $uid = $session->getId();

        self::assertSame('', $uid);
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

        $this->sessionGetsIdAndReturns($token);

        $session = $this->createSession();

        $uid = $session->getId();

        self::assertEquals($token, $uid);
    }

    /**
     * Tests that it won't put non user information into the session
     *
     * @test
     *
     * @return void
     */
    public function it_wont_put_non_user_information_into_the_session()
    {
        $session = $this->createSession();

        $session->put('not_user', 1);

        $this->bus->shouldNotHaveReceived('handler');
    }

    /**
     * Tests that it will update the session if given a user id
     *
     * @test
     *
     * @return void
     */
    public function it_will_update_the_session_with_a_new_random_token_if_there_is_no_existing_session()
    {
        $session = $this->sessionGetsIdAndReturns('')
            ->createSession();

        $session->put('user', 1);

        $this->bus->shouldHaveReceived('handle');
    }

    /**
     * Creates a session
     *
     * @return FixometerSessionService
     */
    protected function createSession()
    {
        /**
         * The command bus
         *
         * @var CommandBus
         */
        $bus = $this->bus;

        /**
         * The repository
         *
         * @var FixometerSessionRepository
         */
        $repository = $this->repository;

        /**
         * The request
         *
         * @var Request
         */
        $request = $this->request;


        return new FixometerSessionService(
            self::SESSION_NAME,
            $bus,
            $repository,
            $request
        );
    }

    /**
     * Sets up the mock request to return the value of the SESSION_NAME cookie
     *
     * @param string $token The token that the getId method returns
     *
     * @return $this
     */
    protected function sessionGetsIdAndReturns($token)
    {
        $this->request->shouldReceive('cookie')
            ->with(self::SESSION_NAME, '')
            ->andReturn($token);

        return $this;
    }
}
