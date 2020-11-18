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
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\ReviewManager;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;
use TheRestartProject\Fixometer\Infrastructure\Doctrine\Repositories\DoctrineUserRepository;

class BusinessController extends Controller
{
    public function edit($id = null, BusinessRepository $repository, DoctrineUserRepository $userRepository)
    {
        $business = $id ? $repository->findById($id) : new Business();

        if (!empty($business->getCreatedBy())) {
            $business->userWhoCreated = $userRepository->find($business->getCreatedBy());
        }
        if (!empty($business->getUpdatedBy())) {
            $business->userWhoLastUpdated = $userRepository->find($business->getUpdatedBy());
        }

        $this->authorize('view', $business);

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

    public function update($id, Request $request, CommandBus $commandBus, ImportFromHttpRequestFactory $commandFactory)
    {
        try {
            $command = $commandFactory->makeFromRequest($request, $id);
            $commandBus->handle($command);
        } catch (BusinessValidationException $e) {
            return redirect()
                ->route('admin.business.edit', [ 'id' => $id ])
                ->withErrors($e->getErrors())
                ->withInput();
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
        $business = $businessRepository->findById($id);
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

    public function scrapeReview(Request $request, ReviewManager $reviewManager)
    {
        $url = $request->input("url");
        $response = $reviewManager->getReviewResponse($url);
        if ($response) {
            $data = $response->toArray();
            return response($data, 200);
        }
        return response('', 404);
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

        if (auth()->user()->can('publish', $business)) {
            $authorizedStatuses = $publishingStatuses;
        } else if (auth()->user()->can('update', $business)) {
            $authorizedStatuses = [
                PublishingStatus::DRAFT,
                PublishingStatus::READY_FOR_REVIEW
            ];
        } else {
            $authorizedStatuses = [];
        }

        return view('admin.business.edit', [
            'categories' => Category::values(),
            'reviewSources' => ReviewSource::values(),
            'publishingStatuses' => $publishingStatuses,
            'authorizedStatuses' => $authorizedStatuses,
            'business' => $business,
            'isCreate' => $isCreate,
            'formAction' => $formAction,
            'formMethod' => $formMethod,
        ]);
    }
}
