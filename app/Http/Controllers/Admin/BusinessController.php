<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class BusinessController extends Controller
{
    /** @var BusinessRepository */
    private $repository;

    public function __construct(BusinessRepository $repository) {
        $this->repository = $repository;
    }

    public function edit($id = null)
    {
        return $this->renderEdit($id, []);
    }

    public function create(Request $request, CommandBus $commandBus)
    {
        try {
            $commandBus->handle(new ImportFromHttpRequestCommand($request->all()));
        } catch (ValidationException $e) {
            return $this->renderEdit(null, $e->getErrors());
        }
        return redirect('admin');
    }

    public function update($id, Request $request, CommandBus $commandBus)
    {
        try {
            $commandBus->handle(new ImportFromHttpRequestCommand($request->all(), $id));
        } catch (ValidationException $e) {
            return $this->renderEdit($id, $e->getErrors());
        }
        return redirect('admin');
    }

    private function renderEdit($id, $errors) {
        $business = $id ? $this->repository->get($id) : new Business();
        $isCreate = $id === null;

        $formAction = $isCreate ? route('admin.business.create') : route('admin.business.update', ['id' => $business->getUid()]);
        $formMethod = $isCreate ? 'post' : 'put';

        return view('admin.business.edit', [
            'categories' => Category::values(),
            'business' => $business,
            'isCreate' => $isCreate,
            'formAction' => $formAction,
            'formMethod' => $formMethod,
            'errors' => $errors
        ]);
    }
}
