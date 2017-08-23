<?php

namespace TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories;

use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;

/**
 * Implementation of the FixometerSessionRepository for doctrine
 *
 * @category Repository
 * @package  TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories
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
     * @return \TheRestartProject\Fixometer\Domain\Entities\FixometerSession|null
     */
    public function findOneBySession($session)
    {
        return $this->repository->findOneBy(['session' => $session]);
    }

    /**
     * Add a new session
     *
     * @param \TheRestartProject\Fixometer\Domain\Entities\FixometerSession $session The Session to add
     *
     * @return void
     */
    public function add(FixometerSession $session)
    {
        $this->entityManager->persist($session);
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

    /**
     * Remove a session
     *
     * @param \TheRestartProject\Fixometer\Domain\Entities\FixometerSession $session The Session to remove
     *
     * @return void
     */
    public function remove(FixometerSession $session)
    {
        $this->entityManager->remove($session);
    }

    /**
     * Find a session by its Id
     *
     * @param int $uid The Unique id for the session
     *
     * @return \TheRestartProject\Fixometer\Domain\Entities\FixometerSession|null
     */
    public function find($uid)
    {
        return $this->repository->find($uid);
    }
}