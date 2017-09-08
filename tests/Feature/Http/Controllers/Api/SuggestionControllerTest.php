<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;

use SuggestionsTableSeeder;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Api\SuggestionController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class SuggestionControllerTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /**
     * Seed the database before we test the Suggestion search api
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->app->make(SuggestionsTableSeeder::class)->run();
    }

    /**
     * Asserts that the SuggestionController->search returns the correct suggestions
     *
     * @return void
     *
     * @test
     */
    public function i_can_search()
    {
        $response = $this->get(route('suggestion.search'));
        $response->assertStatus(400);

        $response = $this->get(
            route(
                'suggestion.search', [
                'field' => 'foo'
                ]
            )
        );
        $response->assertStatus(400);

        $response = $this->get(
            route(
                'suggestion.search', [
                'prefix' => 'foo'
                ]
            )
        );
        $response->assertStatus(400);

        $response = $this->get(
            route(
                'suggestion.search', [
                'field' => 'test',
                'prefix' => 'foo'
                ]
            )
        );
        $response->assertStatus(200);
        $response->assertJson(
            [
                'food', 'football'
            ]
        );
    }
}
