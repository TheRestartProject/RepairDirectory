<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;

use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Tests\Feature\FeatureTestCase;

/**
 * Api\BusinessController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class BusinessControllerTest extends FeatureTestCase
{
    /**
     * Asserts that the BusinessController->search returns all businesses
     * when no query parameters are present on the request
     *
     * @return void
     *
     * @test
     */
    public function test_search_without_location()
    {
        $response = $this->get('/api/business/search');
        $response->assertStatus(200);
        $response->assertJson([
            'searchLocation' => null,
            'businesses' => [
                [
                    'uid' => 1
                ],
                [
                    'uid' => 2
                ]
            ]
        ]);
    }

    /**
     * Asserts that the BusinessController->search returns businesses that match
     * a category when one is provided
     *
     * @return void
     *
     * @test
     */
    public function test_search_with_category()
    {
        $response = $this->get('/api/business/search?category=Computers%20and%20Home%20Office');
        $response->assertStatus(200);
        $response->assertJson([
            'searchLocation' => null,
            'businesses' => [
                [
                    'uid' => 1
                ]
            ]
        ]);
    }

    /**
     * Asserts that the BusinessController->search returns the correct businesses
     * when a location is present in the query parameters
     *
     * @return void
     *
     * @test
     */
    public function test_search_with_location()
    {
        $response = $this->get('/api/business/search?location=RM7%207JN');
        $response->assertStatus(200);
        $response->assertJson([
            'searchLocation' => [
                'latitude' => 51.5847097,
                'longitude' => 0.1706761
            ],
            'businesses' => [
                [
                    "uid" => 1,
                    "name" => "Link Computer Services",
                    "address" => "203 Mawney Road",
                    "postcode" => "RM7 8BX",
                    "geolocation" => [
                        "latitude" => 51.583626,
                        "longitude" => 0.163757
                    ],
                    "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                    "landline" => null,
                    "mobile" => null,
                    "website" => null,
                    "email" => null,
                    "localArea" => null,
                    "category" => null,
                    "productsRepaired" => null,
                    "authorised" => false,
                    "qualifications" => null,
                    "reviews" => null,
                    "positiveReviewPc" => null,
                    "warranty" => null,
                    "pricingInformation" => null
                ]
            ]
        ]);
    }
}
