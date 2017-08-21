<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use TheRestartProject\RepairDirectory\Domain\Models\FixometerSession;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;

/**
 * Implementation of the FixometerSessionRepository for doctrine
 *
 * @category Repository
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrineFixometerSessionRepository extends DoctrineRepository implements FixometerSessionRepository
{
    /**
     * Find a FixometerSession by its session token
     *
     * @param string $session The random string that represents a session
     *
     * @return FixometerSession|null
     */
    public function findOneBySession($session)
    {
        return $this->repository->findOneBy(['session' => $session]);
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return FixometerSession::class;
    }
}