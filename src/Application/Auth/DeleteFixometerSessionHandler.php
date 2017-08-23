<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;

/**
 * Class DeleteFixometerSessionHandler
 *
 * @category Handler
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DeleteFixometerSessionHandler
{
    /**
     * Session repository
     *
     * @var \TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository
     */
    private $repository;

    /**
     * DeleteFixometerSessionHandler constructor.
     *
     * @param FixometerSessionRepository $repository The session repository
     *
     * @return self
     */
    public function __construct(FixometerSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command
     *
     * @param DeleteFixometerSessionCommand $command The command to handle
     */
    public function handle(DeleteFixometerSessionCommand $command)
    {
        $session = $this->repository->find($command->getSessionId());

        if ($session) {
            $this->repository->remove($session);
        }
    }
}