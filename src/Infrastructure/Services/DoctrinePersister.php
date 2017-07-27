<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use Doctrine\ORM\EntityManager;
use TheRestartProject\RepairDirectory\Domain\Services\Persister;

/**
 * Class DoctrinePersister
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class DoctrinePersister implements Persister
{
    private $entityManager;

    /**
     * DoctrinePersister constructor.
     *
     * @param EntityManager $entityManager The Doctrine Entity Manager (autowired)
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Persist all changes to all repositories. Commits any pending transactions.
     *
     * @return void
     */
    public function persistChanges()
    {
        $this->entityManager->flush();
    }
}
