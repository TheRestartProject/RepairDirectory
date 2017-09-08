<?php

namespace App\Http\Controllers;

use TheRestartProject\RepairDirectory\Domain\Enums\Category;

class MapController extends Controller
{
    public function index()
    {
        if ($this->isIpRestricted())
        {
            return response('', 403);
        }
        return view('map', ['categories' => Category::values()]);
    }

    private function isIpRestricted()
    {
        $allowedIps = getenv('ALLOWED_IPS');
        $currentIp = getenv('REMOTE_ADDR');
        if ($allowedIps && $currentIp) {
            $allowedIps = explode(',', $allowedIps);
            return !in_array($currentIp, $allowedIps);
        }
        return false;
    }
}
