<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth;

use Illuminate\Support\Str;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionCommand;
use TheRestartProject\RepairDirectory\Application\Auth\UpdateFixometerSessionHandler;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use Mockery as m;

/**
 * Tests for the FixometerSessionService
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class UpdateFixometerSessionHandlerTest extends TestCase
{
    /**
     * The mocked session repository
     *
     * @var FixometerSessionRepository|m\MockInterface
     */
    protected $sessionRepository;

    /**
     * The mocked User repository
     *
     * @var UserRepository|m\MockInterface
     */
    protected $userRepository;

    protected function setUp()
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
            ->addsNewSession($token, $userId)
            ->handler($command);

        $handler->handle($command);
    }

    /**
     * Creates a handler
     *
     * @return UpdateFixometerSessionHandler
     */
    protected function handler()
    {
        return new UpdateFixometerSessionHandler(
            $this->sessionRepository,
            $this->userRepository
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
     * @return $this
     */
    protected function returnsNoSession($token)
    {
        $this->sessionRepository->shouldReceive('findOneBySession')
            ->with($token)->andReturnNull();

        return $this;
    }

    protected function addsNewSession($token, $userId)
    {
        $this->sessionRepository->shouldReceive('add');

        return $this;
    }
}
