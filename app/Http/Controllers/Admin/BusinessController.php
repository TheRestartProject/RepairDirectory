<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Business\DeleteBusiness\DeleteBusinessCommand;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestFactory;
use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\HideReason;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Repositories\SubmissionRepository;
use TheRestartProject\RepairDirectory\Domain\Services\ReviewManager;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;
use TheRestartProject\RepairDirectory\Infrastructure\Services\GravityFormsSubmissionsRetriever;
use Illuminate\Support\Facades\Auth;
use TheRestartProject\RepairDirectory\Validation\Validators\WebsiteValidator;

class BusinessController extends Controller
{
    private $submissionsRetriever;

    public function __construct()
    {
        $this->submissionsRetriever = new GravityFormsSubmissionsRetriever();
    }

    public function edit(Request $request, BusinessRepository $repository, DoctrineUserRepository $userRepository)
    {
        $id = $request->route('id');
        $business = $id ? $repository->findBusinessForUser($id, Auth::user()) : new Business();

        if (!$business) {
            return response('', 404);
        }

        $this->authorize('view', $business);

        if (!empty($business->getCreatedBy())) {
            $business->userWhoCreated = $userRepository->find($business->getCreatedBy());
        }
        if (!empty($business->getUpdatedBy())) {
            $business->userWhoLastUpdated = $userRepository->find($business->getUpdatedBy());
        }

        return $this->renderEdit($business, []);
    }

    public function create(Request $request, CommandBus $commandBus, ImportFromHttpRequestFactory $commandFactory)
    {
        $this->authorize('create', Business::class);

        $business = null;
        try {
            $command = $commandFactory->makeFromRequest($request);
            $business = $commandBus->handle($command);
        } catch (BusinessValidationException $e) {
            return redirect()
                ->route('admin.business.edit')
                ->withErrors($e->getErrors())
                ->withInput();
        } catch (ImportBusinessUnauthorizedException $e) {
            return redirect()
                ->route('admin.business.edit')
                ->withErrors(['authorization' => 'You are not authorized to create this business.'])
                ->withInput();
        }

        $request->session()->flash('alert-success', 'The business was created successfully.');

        return redirect()->route('admin.business.edit', $business->getUid());
    }

    public function createFromSubmission($id, Request $request, CommandBus $commandBus, ImportFromHttpRequestFactory $commandFactory, SubmissionRepository $repository)
    {
        $this->authorize('create', Business::class);

        $submission = $this->submissionsRetriever->retrieve($id);
        $business = new Business();
        $business->setName($submission->getBusinessName());
        $business->setWebsite($submission->getBusinessWebsite());
        $business->setReviewSourceUrl($submission->getReviewSource());

        $ourSubmission = $repository->findByExternalId($submission->getExternalId());
        $notes = $ourSubmission && $ourSubmission->getNotes() ? ($ourSubmission->getNotes() . "\n\n") : '';

        $business->setNotes(
            "Notes:\n\n$notes\n\n" .
            "Submission date: " . $submission->getCreatedAt() . "\n" .
            "Submitted by employee: " . $submission->getSubmittedByEmployee() . "\n" .
            "Anything else we should know: " . $submission->getExtraInfo()
        );

        // We drop the borough on the submission - this is now determined automatically from the address, and the
        // address is supplied when we submit the creation form.

        return $this->renderEdit($business, []);
    }

    public function update($id, Request $request, CommandBus $commandBus, ImportFromHttpRequestFactory $commandFactory)
    {
        try {
            $command = $commandFactory->makeFromRequest($request, $id);
            $commandBus->handle($command);
        } catch (BusinessValidationException $e) {
            // Go back to edit.  We need to override the publishing status, otherwise it may show as Published, which
            // will be confusing - even though we've had an error, you might think the business has actually been
            // published.
            return redirect()
                ->route('admin.business.edit', [ 'id' => $id ])
                ->withErrors($e->getErrors())
                ->withInput([
                                'publishingStatus' => 'Draft'
                            ]);
        } catch (ImportBusinessUnauthorizedException $e) {
            return redirect()
                ->route('admin.business.edit', [ 'id' => $id ])
                ->withErrors(['authorization' => 'You are not authorized to edit this business.'])
                ->withInput();
        }

        $request->session()->flash('alert-success', 'Your edits to the business were saved successfully.');

        return redirect()->route('admin.business.edit', $id);
    }

    public function delete($id, BusinessRepository $businessRepository, CommandBus $commandBus)
    {
        $business = $businessRepository->findBusinessForUser($id, Auth::user());
        if (!$business) {
            return response('', 404);
        }

        if ($business->getPublishingStatus() === PublishingStatus::DRAFT ||
            $business->getPublishingStatus() === PublishingStatus::READY_FOR_REVIEW) {
            // Not live on the site yet.
            $this->authorize('update', $business);
        } else {
            // Live on the site, and therefore require higher permissions.
            $this->authorize('publish', $business);
        }

        $commandBus->handle(new DeleteBusinessCommand($business));
        return redirect('admin');
    }

    public function validateField(Request $request, BusinessValidator $businessValidator)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        if (!$field) {
            return response('Invalid request', 400);
        }
        try {
            $businessValidator->validateField($field, $value);
        } catch (ValidationException $e) {
            return response($e->getMessage(), 200);
        }
        return response('', 200);
    }

    private function renderEdit(Business $business, $errors)
    {
        $isCreate = $business->getUid() === null;

        $formAction = $isCreate ? route('admin.business.create') : route('admin.business.update', ['id' => $business->getUid()]);
        $formMethod = $isCreate ? 'post' : 'put';

        if ($isCreate) {
            $business->setPublishingStatus(PublishingStatus::DRAFT);
        }

        $publishingStatuses = PublishingStatus::values();
        $hideReasons = HideReason::values();

        if (auth()->user()->can('publish', $business)) {
            $authorizedStatuses = $publishingStatuses;
        } else if (auth()->user()->can('update', $business)) {
            $authorizedStatuses = [
                PublishingStatus::DRAFT,
                PublishingStatus::READY_FOR_REVIEW,
                PublishingStatus::HIDDEN
            ];
        } else {
            $authorizedStatuses = [];
        }

        // We want to indicate whether the website is valid.
        $v = new WebsiteValidator();
        $websiteInvalid = NULL;

        try {
            if ($business->getWebsite()) {
                $v->validate($business->getWebsite());
            }
        } catch (ValidationException $e) {
            $websiteInvalid = $e->getMessage();
        }

        return view('admin.business.edit', [
            'categories' => Category::values(),
            'reviewSources' => ReviewSource::values(),
            'publishingStatuses' => $publishingStatuses,
            'hideReasons' => $hideReasons,
            'authorizedStatuses' => $authorizedStatuses,
            'business' => $business,
            'isCreate' => $isCreate,
            'formAction' => $formAction,
            'formMethod' => $formMethod,
            'websiteInvalid' => $websiteInvalid
        ]);
    }
}
