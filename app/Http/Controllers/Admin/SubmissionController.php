<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;

class SubmissionController extends Controller
{
    public function index()
    {
        $retriever = new GravityFormsSubmissionsRetriever();

        $submissions = $retriever->retrieveAll();

        return view('admin.submissions.index', [
            'submissions' => $submissions
        ]);
    }

    public function view($id)
    {
        $retriever = new GravityFormsSubmissionsRetriever();

        $submission = $retriever->retrieve($id);

        return view('admin.submissions.view', [
            'submission' => $submission
        ]);
    }
}
