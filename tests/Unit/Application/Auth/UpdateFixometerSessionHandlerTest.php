<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth;

use Illuminate\Support\Str;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionHandler;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use Mockery as m;

/**
 * Tests for the FixometerSessionService
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class UpdateFixometerSessionHandlerTest extends TestCase
{
    /**
     * The mocked session repository
     *
     * @var \TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository|m\MockInterface
     */
    protected $sessionRepository;

    /**
     * The mocked User repository
     *
     * @var UserRepository|m\MockInterface
     */
    protected $userRepository;

    /**
     * Sets up the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sessionRepository = m::mock(FixometerSessionRepository::class);
        $this->userRepository = m::mock(UserRepository::class);
    }


    /**
     * It handles a command to create a new session
     *
     * @test
     *
     * @return void
     */
    public function it_handles_a_command_to_create_a_new_session()
    {
        $token = Str::random(45);
        $userId = 1;
        $command = new UpdateFixometerSessionCommand($token, $userId);

        $handler = $this->userExists($userId)
            ->returnsNoSession($token)
            ->addsNewSession()
            ->handler();

        $handler->handle($command);
    }

    /**
     * Creates a handler
     *
     * @return UpdateFixometerSessionHandler
     */
    protected function handler()
    {
        /**
         * The session repository
         *
         * @var \TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository $sessionRepository
         */
        $sessionRepository = $this->sessionRepository;

        /**
         * The user repository
         *
         * @var UserRepository $userRepository
         */
        $userRepository = $this->userRepository;

        return new UpdateFixometerSessionHandler(
            $sessionRepository,
            $userRepository
        );
    }

    /**
     * Sets up the user repository to return true as if a user existed
     *
     * @param integer $userId The user id
     *
     * @return $this
     */
    protected function userExists($userId)
    {
        $this->userRepository->shouldReceive('hasUserById')
            ->with($userId)->andReturn(true);

        return $this;
    }

    /**
     * Sets up the Session Repository
     *
     * @param string $token The token to search the session on
     *
     * @return $this
     */
    protected function returnsNoSession($token)
    {
        $this->sessionRepository->shouldReceive('findOneBySession')
            ->with($token)->andReturnNull();

        return $this;
    }

    /**
     * Sets up the mock to accept the add method
     *
     * @return $this
     */
    protected function addsNewSession()
    {
        $this->sessionRepository->shouldReceive('add');

        return $this;
    }
}
