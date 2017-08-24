<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use Carbon\Carbon;
use TheRestartProject\RepairDirectory\Application\CommandBus\Exceptions\NotFoundException;
use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;


/**
 * Class UpdateFixometerSessionHandler
 *
 * @category Handler
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
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
     * @param FixometerSessionRepository $sessionRepository The session repository
     * @param UserRepository             $userRepository    The user repository
     */
    public function __construct(
        FixometerSessionRepository $sessionRepository,
        UserRepository $userRepository
    ) {

        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Updates the Fixometer Session with the user id
     *
     * @param UpdateFixometerSessionCommand $command The command to update
     *
     * @throws NotFoundException
     *
     * @return void
     */
    public function handle(UpdateFixometerSessionCommand $command)
    {
        $now = new Carbon('now');
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