<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class BusinessController extends Controller
{
    public function edit($id = null, BusinessRepository $repository)
    {
        $business = $id ? $repository->get($id) : new Business();

        $isCreate = $id === null;
        $formAction = $isCreate ? route('admin.business.create') : route('admin.business.update', ['id' => $business->getUid()]);
        $formMethod = $isCreate ? 'post' : 'put';

        return view('admin.business.edit', [
            'business' => $business,
            'isCreate' => $isCreate,
            'formAction' => $formAction,
            'formMethod' => $formMethod
        ]);
    }

    public function create(Request $request, CommandBus $commandBus)
    {
        $commandBus->handle(new ImportFromHttpRequestCommand($request->all()));
        return redirect('admin');
    }

    public function update($id, Request $request, CommandBus $commandBus)
    {
        $commandBus->handle(new ImportFromHttpRequestCommand($request->all(), $id));
        return redirect('admin');
    }
}
