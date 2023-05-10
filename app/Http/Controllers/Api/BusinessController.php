<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Application\QueryLanguage\Operators;
use TheRestartProject\RepairDirectory\Domain\Enums\Region;
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
        $region = $request->input('region', Region::LONDON);

        // There are different criteria for different regions.
        $criteria = Region::CRITERIA[$region];
        
        if ($category) {
            // The categories field is JSON-encoded, so any forward slash will be escaped.  We need to escape it here
            // so that the LIKE matches.  But we can't add a \ as that then confuses Doctrine.  So use the single
            // character wildcard, so that we will match \/ in the field.
            $criteria[] = [
                'field' => 'categories',
                'operator' => Operators::CONTAINS,
                'value' => str_replace('/', '_/', $category)
            ];
        }

        $businesses = [];
        $searchLocation = null;

        // The region is a hint for geocoding.
        $location = $location ? "$location, $region, UK" : "$region, UK";

        $searchLocation = $geocoder->geocode($location);
        if ($searchLocation) {
            $businesses = $repository->findByLocation($searchLocation, $radius, $criteria);
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
