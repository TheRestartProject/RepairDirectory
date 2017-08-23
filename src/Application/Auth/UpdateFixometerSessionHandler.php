<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;
use Carbon\Carbon;
use TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions\NotFoundException;
use TheRestartProject\RepairDirectory\Domain\Models\FixometerSession;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\RepairDirectory\Domain\Repositories\UserRepository;


/**
 * Class UpdateFixometerSessionHandler
 * @category Handler
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class UpdateFixometerSessionHandler
{
    /**
     * The session repository
     *
     * @var FixometerSessionRepository
     */
    protected $sessionRepository;

    /**
     * The user repository
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UpdateFixometerSessionHandler constructor.
     *
     * @param FixometerSessionRepository $sessionRepository
     * @param UserRepository             $userRepository
     */
    public function __construct(
        FixometerSessionRepository $sessionRepository,
        UserRepository $userRepository
    ) {

        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(UpdateFixometerSessionCommand $command)
    {
        $now = Carbon::now();
        $userId = $command->getUserId();
        $token = $command->getToken();

        if (!$this->userRepository->hasUserById($userId)) {
            throw new NotFoundException("No User found with id of {$userId}");
        }

        $session = $this->sessionRepository->findOneBySession($token);

        if ($session === null) {
            $session = new FixometerSession();
            $session->setCreatedAt($now);
            $this->sessionRepository->add($session);
        }

        $session->setUser($userId);
        $session->setSession($token);
        $session->setModifiedAt($now);
    }
}