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
    public function create()
    {
        $business = new Business();
        return view('admin.business.show', compact('business'));
    }

    public function store(Request $request, CommandBus $commandBus)
    {
        $business = $commandBus->handle(new ImportFromHttpRequestCommand($request));
        return view('admin.business.show', compact('business'));
    }

    public function show($id, BusinessRepository $repository)
    {
        $business = $repository->get($id);
        return view('admin.business.show', compact('business'));
    }

    public function update($id, Request $request, CommandBus $commandBus)
    {
        $commandBus->handle(new ImportFromHttpRequestCommand($request, $id));
        return view('admin.business.show', compact('business'));
    }
}
