<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class AdminController extends Controller
{
    public function index(BusinessRepository $repository)
    {
        $businesses = $repository->findAll();
        return view('admin.index', compact('businesses'));
    }
}
