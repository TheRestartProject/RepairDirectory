<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;

use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Api\BusinessController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class BusinessControllerTest extends IntegrationTestCase
{
    use DatabaseMigrations;
    /**
     * Asserts that the BusinessController->search returns no businesses
     * when no query parameters are present on the request
     *
     * @return void
     *
     * @test
     */
    public function i_can_search_without_location()
    {
        entity(Business::class, 3)->create();

        $response = $this->get(route('business.search'));
        $response->assertStatus(200);
        $response->assertJson(
            [
                'searchLocation' => null,
                'businesses' => []
            ]
        );
    }

    /**
     * Asserts that the BusinessController->search returns businesses that match
     * a category when one is provided
     *
     * @return void
     *
     * @test
     */
    public function i_can_search_with_category()
    {
        entity(Business::class, 3)->create();

        $response = $this->get(
            route(
                'business.search', [
                    'categories' => [Category::DESKTOP, Category::LAPTOP]
                ]
            )
        );
        $response->assertStatus(200);
        $response->assertJson(
            [
                'searchLocation' => null,
                'businesses' => []
            ]
        );
    }

    /**
     * Asserts that the BusinessController->search returns the correct businesses
     * when a location is present in the query parameters
     *
     * @return void
     *
     * todo: don't seed this in advance create the businesses for this specific test
     */
    public function i_can_search_with_location()
    {
        $response = $this->get(
            route(
                'business.search', [
                    'location' => 'RM7 7JN'
                ]
            )
        );
        $response->assertStatus(200);
        $response->assertJson(
            [
                'searchLocation' => [
                    'latitude' => 51.5847097,
                    'longitude' => 0.1706761
                ],
                'businesses' => [
                    [
                        'uid' => 1,
                        'name' => 'Link Computer Services',
                        'address' => '203 Mawney Road',
                        'postcode' => 'RM7 8BX',
                        'geolocation' => [
                            'latitude' => 51.583626,
                            'longitude' => 0.163757
                        ],
                        'description' => 'Laptop, PC, and Netbook repairs, mobile service.'
                    ]
                ]
            ]
        );
    }

    /**
     * Asserts that the BusinessController->search returns businesses that match
     * a category and location when both are provided
     *
     * @return void
     *
     * todo: don't seed this in advance create the businesses for this specific test
     */
    public function i_can_search_with_category_and_location()
    {
        $response = $this->get(
            route(
                'business.search', [
                    'categories' => [Category::DESKTOP],
                    'location' => 'RM7 7JN'
                ]
            )
        );
        $response->assertStatus(200);
        $response->assertJson(
            [
                'searchLocation' => [
                    'latitude' => 51.5847097,
                    'longitude' => 0.1706761
                ],
                'businesses' => [
                    [
                        'uid' => 1
                    ]
                ]
            ]
        );
    }
}
