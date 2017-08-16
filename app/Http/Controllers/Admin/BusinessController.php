<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class BusinessController extends Controller
{
    public function edit($id = null, BusinessRepository $repository)
    {
        $business = $id ? $repository->get($id) : new Business();
        return $this->renderEdit($business, []);
    }

    public function create(Request $request, CommandBus $commandBus)
    {
        try {
            $commandBus->handle(new ImportFromHttpRequestCommand($request->all()));
        } catch (BusinessValidationException $e) {
            return $this->renderEdit($e->getBusiness(), $e->getErrors());
        }
        return redirect('map/admin');
    }

    public function update($id, Request $request, CommandBus $commandBus)
    {
        try {
            $commandBus->handle(new ImportFromHttpRequestCommand($request->all(), $id));
        } catch (BusinessValidationException $e) {
            return $this->renderEdit($e->getBusiness(), $e->getErrors());
        }
        return redirect('map/admin');
    }

    private function renderEdit(Business $business, $errors) {
        $isCreate = $business->getUid() === null;

        $formAction = $isCreate ? route('admin.business.create') : route('admin.business.update', ['id' => $business->getUid()]);
        $formMethod = $isCreate ? 'post' : 'put';

        return view('admin.business.edit', [
            'categories' => Category::values(),
            'reviewSources' =>ReviewSource::values(),
            'business' => $business,
            'isCreate' => $isCreate,
            'formAction' => $formAction,
            'formMethod' => $formMethod,
            'errors' => $errors
        ]);
    }
}
