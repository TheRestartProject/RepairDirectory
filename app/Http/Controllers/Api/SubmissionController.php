<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Submission\AddSubmission\AddSubmissionCommand;
use TheRestartProject\RepairDirectory\Domain\Models\Submission;
use TheRestartProject\RepairDirectory\Domain\Repositories\SubmissionRepository;
use Doctrine\ORM\EntityManager;

class SubmissionController extends Controller
{
    public function status(EntityManager $em, SubmissionRepository $repository)
    {
        $id = Route::current()->parameter('id');
        $status = Route::current()->parameter('status');

        if (!$id || !$status) {
            return response('You must include an id and a status', 400);
        }

        $submission = $repository->findById($id);

        if (!$submission) {
            return response("Business not found");
        }

        $submission->setStatus($status);
        $em->flush();

        return [
            'status' => $submission->getStatus()
        ];
    }
}
