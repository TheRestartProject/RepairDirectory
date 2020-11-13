<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;

class SubmissionController extends Controller
{
    private $submissionsRetriever;

    public function __construct()
    {
        $this->submissionsRetriever = new GravityFormsSubmissionsRetriever();
    }

    public function index()
    {
        $this->authorize('index', Submission::class);

        $submissions = $this->submissionsRetriever->retrieveAll();

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
