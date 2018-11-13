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
        return view('map', ['categories' => Category::values(), 'radiusOptions' => [1, 3, 5, 7, 10]]);
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
