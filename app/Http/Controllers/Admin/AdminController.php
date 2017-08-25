<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class AdminController extends Controller
{
    public function index(BusinessRepository $repository)
    {
        $this->authorize('index', Business::class);

        $businesses = $repository->findAll();

        return view('admin.index', compact('businesses'));
    }
}
