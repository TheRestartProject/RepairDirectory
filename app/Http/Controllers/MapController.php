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
            $geolocation = $geocoder->geocode($search);
            $businesses = $repository->findByLocation($geolocation);
        } else {
            $businesses = $repository->getAll();
        }

        $businessesJson = array_map(
            function (Business $business) {
                return $business->toJson();
            },
            $businesses
        );
        JavaScript::put([
            'businesses' => $businessesJson
        ]);
        return view('map', compact('search'));
    }
}
