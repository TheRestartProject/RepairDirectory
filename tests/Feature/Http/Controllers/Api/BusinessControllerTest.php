<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;


use Database\Seeders\BusinessesTableSeeder;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
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
     * Seed the database before we test the Business search API
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make(BusinessesTableSeeder::class)->run();
    }

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
        $response = $this->get(
            route(
                'business.search',
                [
                    'category' => Category::DESKTOP
                ]
            )
        );
        $response->assertStatus(200);
        $response->assertJson(
            [
                'searchLocation' => null,
                'businesses' => [
                    [
                        'uid' => 1,
                    ],
                    [
                        'uid' => 3
                    ]
                ]
            ]
        );
    }

    /**
     * Asserts that the BusinessController->search returns the correct businesses
     * when a location is present in the query parameters
     *
     * @return void
     *
     * @test
     */
    public function i_can_search_with_location()
    {
        $response = $this->get(
            route(
                'business.search',
                [
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
                        'description' => 'PC repairs'
                    ],
                    [
                        'uid' => 2,
                        'description' => 'Laptop repairs'
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
     * @test
     */
    public function i_can_search_with_category_and_location()
    {
        $response = $this->get(
            route(
                'business.search',
                [
                    'category' => Category::DESKTOP,
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
