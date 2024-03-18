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
        echo('Business index\n');
        try {
            $this->authorize('index', Business::class);
            error_log('Authorised');
        } catch (\Exception $e) {
            echo('Not authorised ' . $e->getMessage() . "\n");
        }

        $businesses = $repository->findAll(Auth::user());

        echo('Found\n');

        return view('admin.index', compact('businesses'));
    }
}
