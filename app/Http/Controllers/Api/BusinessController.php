<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\Geocoder;

class BusinessController extends Controller
{
    public function search(Request $request, BusinessRepository $repository, Geocoder $geocoder)
    {
        $location = $request->input('location');

        $businesses = [];
        $searchLocation = null;

        if ($location) {
            $searchLocation = $geocoder->geocode($location);
            if ($searchLocation) {
                $businesses = $repository->findByLocation($searchLocation);
            }
        } else {
            $businesses = $repository->getAll();
        }

        $businessesAsArrays = array_map(
            function (Business $business) {
                return $business->toArray();
            },
            $businesses
        );

        $searchLocationAsArray = $searchLocation ? $searchLocation->toArray() : null;

        return [
            'businesses' => $businessesAsArrays,
            'searchLocation' => $searchLocationAsArray
        ];
    }
}
