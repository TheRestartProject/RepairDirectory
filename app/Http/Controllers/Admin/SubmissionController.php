<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Doctrine\ORM\EntityManagerInterface;
use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\RepairDirectory\Domain\Repositories\SubmissionRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;

class SubmissionController extends Controller
{
    private $submissionsRetriever;

    public function __construct()
    {
        $this->submissionsRetriever = new GravityFormsSubmissionsRetriever();
    }

    public function index(EntityManagerInterface $em, SubmissionRepository $repository)
    {
        $this->authorize('index', Submission::class);

        // Retrieve all the submissions from Gravity.
        $submissions = $this->submissionsRetriever->retrieveAll();

        // Make sure they exist in our repository, which is currently used purely for status tracking.
        foreach ($submissions as $submission) {
            // We need to ensure that the status field is not overwritten by merge() for existing entries.
            $existing = $repository->findByExternalId($submission->getExternalId());

            if ($existing) {
                $submission->setStatus($existing->getStatus());
            }

            $em->merge($submission);
        }

        $em->flush();

        return view('admin.submissions.index', [
            'submissions' => $submissions
        ]);
    }

    public function view($id)
    {
        $this->authorize('view', Submission::class);

        $submission = $this->submissionsRetriever->retrieve($id);

        return view('admin.submissions.view', [
            'submission' => $submission
        ]);
    }
}
