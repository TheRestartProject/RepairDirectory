<?php
/**
 * Created by PhpStorm.
 * User: Joaquim
 * Date: 26/07/2017
 * Time: 21:09
 */

namespace TheRestartProject\RepairDirectory\Infrastructure\Services;

use Doctrine\ORM\EntityManager;
use TheRestartProject\RepairDirectory\Domain\Services\Persister;

class DoctrinePersister implements Persister
{
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function commit() {
        $this->entityManager->flush();
    }
}