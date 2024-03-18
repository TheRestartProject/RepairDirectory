<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(BusinessRepository $repository)
    {
        error_log('Business index');
        $this->authorize('index', Business::class);
        error_log('Authorised');

        $businesses = $repository->findAll(Auth::user());

        error_log('Found');

        return view('admin.index', compact('businesses'));
    }
}
