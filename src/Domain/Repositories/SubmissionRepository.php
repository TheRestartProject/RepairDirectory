<?php

namespace TheRestartProject\RepairDirectory\Domain\Repositories;

use TheRestartProject\RepairDirectory\Domain\Models\Submission;

/**
 * Interface SubmissionRepository
 *
 * @category Interface
 * @package  TheRestartProject\RepairDirectory\Domain\Repositories
 */
interface SubmissionRepository
{
    /**
     * Add a Submission to the repository.
     *
     * @param Submission $submission The Submission to add
     *
     * @return void
     */
    public function add(Submission $submission);

    /**
     * Find a submission.
     *
     * @param integer $uid The Submission id
     *
     * @return Submission
     */
    public function findById($uid);
}
