<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\RepairDirectory\Domain\Repositories\SubmissionRepository;

/**
 * Class DoctrineSubmissionRepository
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Repositories
 */
class DoctrineSubmissionRepository extends DoctrineRepository implements SubmissionRepository
{
    /**
     * Register a new Submission with the entity manager.
     *
     * @param Submission $Submission The Submission to add
     *
     * @return void
     */
    public function add(Submission $Submission)
    {
        $this->entityManager->persist($Submission);
    }

    /**
     * Return the class name of the entity that this repository is for.
     *
     * @return string
     */
    protected function getEntityClass()
    {
        return Submission::class;
    }

    /**
     * Finds the submission by the internal id or returns null.
     *
     * @param integer $uid The id of the submission to find
     *
     * @return Submission|null
     */
    public function findById($uid)
    {
        return $this->repository->find($uid);
    }

    /**
     * Finds the submission by external id or returns null.
     *
     * @param integer $externalId The id of the submission to find
     *
     * @return Submission|null
     */
    public function findByExternalId(int $externalId)
    {
        return $this->repository->findOneBy([ 'externalId' => $externalId ]);
    }
}
