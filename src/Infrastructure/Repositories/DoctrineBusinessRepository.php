<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 26/07/17
 * Time: 11:20
 */

namespace TheRestartProject\RepairDirectory\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

class DoctrineBusinessRepository implements BusinessRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Business $business) {
        $this->entityManager->persist($business);
    }

    public function persist() {
        $this->entityManager->flush();
    }
}
