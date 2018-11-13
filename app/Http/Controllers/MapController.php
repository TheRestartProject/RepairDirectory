<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;

class MapController extends Controller
{
    public function index(Request $request)
    {
        if ($this->isIpRestricted())
        {
            return response('', 403);
        }

        return view('map', [
            'categories' => Category::values(),
            'radiusOptions' => config('map.radiuses'),
            'selectedRadius' => $this->selectedRadius($request)
        ]);
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

    /**
     * Get the selected radius either from the request of use the default
     *
     * The selected radius is the radius that should be selected when the page is
     * loaded. If the page is loaded without a query string then it should use the
     * default value specified in the config, otherwise it will use the value
     * in the query string for radius.
     *
     * @param Request $request The request object
     *
     * @return int
     */
    protected function selectedRadius(Request $request)
    {
        $selectedRadius = $request->input('radius') ?: config('map.default_radius');

        return (int) $selectedRadius;
    }
}
