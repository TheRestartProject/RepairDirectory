<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;

class BusinessController extends Controller
{
    public function index(BusinessRepository $repository)
    {
        $businesses = $repository->getAll();

        return view('admin.business.index', compact('businesses'));
    }

}
