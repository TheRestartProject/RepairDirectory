<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services\Reviewers;

use Illuminate\Support\Collection;
use Mockery;
use SKAgarwal\GoogleApi\PlacesApi;
use TheRestartProject\RepairDirectory\Domain\Models\ReviewAggregation;
use TheRestartProject\RepairDirectory\Infrastructure\Services\Reviewers\GooglePlacesReviewer;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Class GooglePlacesReviewerTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\Services\Reviewers
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class GooglePlacesReviewerTest extends IntegrationTestCase
{
    /**
     * Test that malformed URL input to the service does not error and returns null
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_for_malformed_url()
    {
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPlacesApi());

        $malformedUrls = [
            'https://sdf',
            'google.com',
            'google.com/maps/',
            'google.com/maps/place/',
            'google.com/maps/place/KFC',
            'google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=',
            'google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m'
        ];

        foreach ($malformedUrls as $url) {
            $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);
            self::assertNull($reviewAggregation);
        }
    }

    /**
     * Test that a well formed URL to a non-existent place does not error and returns null
     *
     * @test
     *
     * @return void
     */
    public function it_returns_null_for_an_unknown_place()
    {
        $url = 'https://www.google.co.uk/maps/place/Nowhere/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPlacesApi());
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        self::assertNull($reviewAggregation);
    }

    /**
     * Test that a real URL returns a ReviewAggregation
     *
     * @test
     *
     * @return void
     */
    public function it_returns_a_review_aggregation_for_good_url()
    {
        $url = 'https://www.google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342';
        $googlePlacesReviewer = new GooglePlacesReviewer($this->getPlacesApi());
        $reviewAggregation = $googlePlacesReviewer->getReviewAggregation($url);

        $expected = new ReviewAggregation();
        $expected->setAverageScore(3);

        self::assertEquals($expected, $reviewAggregation);
    }

    /**
     * Set up a mocked instance of the PlacesApi library
     *
     * @return PlacesApi
     */
    private function getPlacesApi()
    {

        $placesApi = Mockery::mock(PlacesApi::class);

        $emptySearchResponse = new Collection();
        $emptySearchResponse->put('results', new Collection());
        $placesApi
            ->shouldReceive('nearbySearch')
            ->with('51.3795758,-2.3584342', 10, [ 'name' => 'Nowhere' ])
            ->andReturn($emptySearchResponse);

        $nearbySearchResults = new Collection();
        $nearbySearchResults->push(
            [
                'place_id' => 1
            ]
        );
        $nearbySearchResponse = new Collection();
        $nearbySearchResponse->put('results', $nearbySearchResults);
        $placesApi
            ->shouldReceive('nearbySearch')
            ->with('51.3795758,-2.3584342', 10, [ 'name' => 'KFC' ])
            ->andReturn($nearbySearchResponse);

        $placeDetailsResponse = new Collection();
        $placeDetailsResponse->put(
            'result',
            [
            'rating' => 3,
            'reviews' => [
                [ 'rating' => 2 ],
                [ 'rating' => 4 ]
            ]
            ]
        );
        $placesApi->shouldReceive('placeDetails')->andReturn($placeDetailsResponse);

        /** @var PlacesApi $placesApi */
        return $placesApi;
    }
}
