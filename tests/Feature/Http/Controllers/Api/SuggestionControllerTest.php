<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;

use TheRestartProject\RepairDirectory\Tests\FeatureTestCase;

/**
 * Api\SuggestionController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Api;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class SuggestionControllerTest extends FeatureTestCase
{
    /**
     * Asserts that the SuggestionController->search returns the correct suggestions
     *
     * @return void
     *
     * @test
     */
    public function test_search()
    {
        $response = $this->get(route('suggestion.search'));
        $response->assertStatus(400);

        $response = $this->get(route('suggestion.search', [
            'field' => 'foo'
        ]));
        $response->assertStatus(400);

        $response = $this->get(route('suggestion.search', [
            'prefix' => 'foo'
        ]));
        $response->assertStatus(400);

        $response = $this->get(route('suggestion.search', [
            'field' => 'test',
            'prefix' => 'foo'
        ]));
        $response->assertStatus(200);
        $response->assertJson(
            [
                'food', 'football'
            ]
        );
    }
}
