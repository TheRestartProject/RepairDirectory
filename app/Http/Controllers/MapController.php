<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class MapController extends Controller
{
    public function index(Request $request, BusinessRepository $repository, Geocoder $geocoder)
    {
        $search = $request->input('search');

        if ($search) {
            $searchLocation = $geocoder->geocode($search);
            $businesses = $repository->findByLocation($searchLocation);
        } else {
            $searchLocation = null;
            $businesses = $repository->getAll();
        }

        $businessesJson = array_map(
            function (Business $business) {
                return $business->toArray();
            },
            $businesses
        );

        $searchLocationJson = $searchLocation ? $searchLocation->toArray() : null;

        JavaScript::put([
            'searchLocation' => $searchLocationJson,
            'businesses' => $businessesJson
        ]);
        return view('map', compact('search'));
    }
}
