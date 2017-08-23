<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;

/**
 * Class DeleteFixometerSessionHandler
 * @category Handler
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class DeleteFixometerSessionHandler
{
    /**
     * @var FixometerSessionRepository
     */
    private $repository;

    public function __construct(FixometerSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DeleteFixometerSessionCommand $command)
    {
        $session = $this->repository->find($command->getSessionId());

        if ($session) {
            $this->repository->remove($session);
        }
    }
}