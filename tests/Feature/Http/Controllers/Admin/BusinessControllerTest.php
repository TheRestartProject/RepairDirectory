<?php

namespace Tests\Feature\Http\Controllers\Admin;

use TheRestartProject\RepairDirectory\Tests\Feature\FeatureTestCase;

class BusinessControllerTest extends FeatureTestCase
{
    /**
     * Asserts that the BusinessController->store function creates a new Business
     * and persists this in the database
     *
     * @return void
     *
     * @test
     */
    public function test_store()
    {
        $response = $this->post('/admin/business', [
            'name' => 'iRepair Centre Bath',
            'description' => 'Bath\'s iRepair Centre. Fix all your broken devices.',
            'address' => '12 Westgate St, Bath',
            'postcode' => 'BA1 1EQ'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'businesses', [
                'name' => 'iRepair Centre Bath',
                'description' => 'Bath\'s iRepair Centre. Fix all your broken devices.',
                'address' => '12 Westgate St, Bath',
                'postcode' => 'BA1 1EQ',
                'geolocation' => 'a:2:{i:0;d:51.3813963;i:1;d:-2.3613877;}'
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
        $response = $this->put('/admin/business/1', [
            'name' => 'This is a new name',
            'description' => 'This is a new description.'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas(
            'businesses', [
                'name' => 'This is a new name',
                'description' => 'This is a new description.'
            ]
        );
    }
}