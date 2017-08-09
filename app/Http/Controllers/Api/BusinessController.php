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
        $category = $request->input('category');
        $radius = $request->input('radius') ?: 5;

        $businesses = [];
        $searchLocation = null;

        if ($location) {
            $searchLocation = $geocoder->geocode($location);
            if ($searchLocation) {
                $businesses = $repository->findByLocation($searchLocation, $radius);
            }
        } else {
            $businesses = $repository->getAll();
        }
        
        if ($category) {
            $businesses = array_values(
                array_filter($businesses, function (Business $business) use ($category) {
                    return $business->getCategory() === $category;
                })
            );
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
