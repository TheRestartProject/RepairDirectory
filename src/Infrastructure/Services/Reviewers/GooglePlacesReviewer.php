<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 24/08/2017
 * Time: 12:32
 */

namespace TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers;


use SKAgarwal\GoogleApi\PlacesApi;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Domain\Services\Reviewers\Reviewer;

class GooglePlacesReviewer implements Reviewer
{
    /** @var PlacesApi */
    private $googlePlaces;

    public function __construct(PlacesApi $googlePlaces)
    {
        $this->googlePlaces = $googlePlaces;
    }
    /**
     * @param string $url
     * @return ReviewAggregation
     */
    public function getReviewAggregation($url)
    {
        $nameAndLocation = $this->extractNameAndLocationFromGooglePlaceUrl($url);
        if (!$nameAndLocation) {
            return null;
        }

        // call the places API
        $places = $this->googlePlaces->nearbySearch(
            $nameAndLocation['location'], 10, ['name' => $nameAndLocation['name']])->get('results');
        $place = $places->get(0);
        if (!$place) {
            return null;
        }

        $placeId = $place['place_id'];
        $placeDetails = $this->googlePlaces->placeDetails($placeId)->get('result');

        $reviewAggregation = new ReviewAggregation();
        $reviewAggregation->setAverageScore($placeDetails['rating']);

        return $reviewAggregation;
    }

    private function extractNameAndLocationFromGooglePlaceUrl($url)
    {
        $parsedUrl = parse_url($url);

        if (!array_key_exists('path', $parsedUrl)) {
            return null;
        }

        $path = $parsedUrl['path'];

        // extract the place name
        $placeIndex = strpos($path, '/place/');
        if ($placeIndex === false) {
            return null;
        }
        $nameIndex = $placeIndex + strlen('/place/');
        $endNameIndex = strpos($path, '/', $nameIndex);
        if ($endNameIndex === false) {
            return null;
        }
        $name = urldecode(substr($path, $nameIndex, $endNameIndex - $nameIndex));

        // extract lat/lng
        $latitude = null;
        $longitude = null;
        $dataIndex = strpos($path, 'data=');
        if ($dataIndex === false) {
            return null;
        }
        $dataStart = $dataIndex + strlen('data=');
        $dataString = substr($path, $dataStart);
        $data = explode('!', $dataString);
        foreach ($data as $datum) {
            if (strpos($datum, '3d') === 0) {
                $latitude = substr($datum, 2);
            }
            if (strpos($datum, '4d') === 0) {
                $longitude = substr($datum, 2);
            }
        }
        if (!$latitude || !$longitude) {
            return null;
        }

        return [
            'name' => $name,
            'location' => $latitude . ',' . $longitude
        ];
    }
}