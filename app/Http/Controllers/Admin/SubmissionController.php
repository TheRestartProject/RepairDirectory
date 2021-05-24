<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
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
                $submission->setNotes($existing->getNotes());
            }

            $em->merge($submission);
        }

        $em->flush();

        return view('admin.submissions.index', [
            'submissions' => $submissions
        ]);
    }

    public function view($id, SubmissionRepository $repository)
    {
        $this->authorize('view', Submission::class);

        $submission = $this->submissionsRetriever->retrieve($id);

        $existing = $repository->findByExternalId($submission->getExternalId());

        if ($existing) {
            $submission->setStatus($existing->getStatus());
            $submission->setNotes($existing->getNotes());
        }

        try {
            $this->authorize('update', Submission::class);
            $canUpdate = true;
        } catch (\Exception $e) {
            $canUpdate = false;
        }

        return view('admin.submissions.view', [
            'submission' => $submission,
            'canUpdate' => $canUpdate
        ]);
    }

    public function update($id,EntityManagerInterface $em, SubmissionRepository $repository, Request $request) {
        try {
            $this->authorize('update', Submission::class);

            $submission = $this->submissionsRetriever->retrieve($id);

            if ($request->input('status')) {
                $submission->setStatus($request->input('status'));
            }

            if ($request->input('notes')) {
                $submission->setNotes($request->input('notes'));
            }

            $em->merge($submission);
            $em->flush();
            return redirect()
                ->route('admin.submissions.view', [ 'id' => $id ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.submissions.view', [ 'id' => $id ])
                ->withErrors(['authorization' => 'You are not authorized to edit this submission.'])
                ->withInput();
        }
    }
}
