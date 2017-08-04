<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Admin;

use TheRestartProject\RepairDirectory\Tests\Feature\FeatureTestCase;

/**
 * BusinessController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Admin;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class BusinessControllerTest extends FeatureTestCase
{
    /**
     * Asserts that the BusinessController->create function creates a new Business
     * and persists this in the database
     *
     * @return void
     *
     * @test
     */
    public function test_create()
    {
        $response = $this->post(
            '/admin/business', [
                'name' => 'iRepair Centre Bath',
                'description' => 'Bath\'s iRepair Centre. Fix all your broken devices.',
                'address' => '12 Westgate St, Bath',
                'postcode' => 'BA1 1EQ'
            ]
        );
        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'businesses', [
                'name' => 'iRepair Centre Bath',
                'description' => 'Bath\'s iRepair Centre. Fix all your broken devices.',
                'address' => '12 Westgate St, Bath',
                'postcode' => 'BA1 1EQ'
            ]
        );
    }

    /**
     * Asserts that the BusinessController->update function updates an existing Business
     * and persists this in the database
     *
     * @return void
     *
     * @test
     */
    public function test_update()
    {
        $response = $this->put(
            '/admin/business/1', [
                'name' => 'This is a new name',
                'description' => 'This is a new description.'
            ]
        );
        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'businesses', [
                'uid' => 1,
                'name' => 'This is a new name',
                'description' => 'This is a new description.'
            ]
        );
    }
}
