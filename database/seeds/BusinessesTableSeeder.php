<?php

use Illuminate\Database\Seeder;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first business has known data
        entity(Business::class)->create([
            'name' => 'Link Computer Services',
            'description' => 'Laptop, PC, and Netbook repairs, mobile service.',
            'address' => '203 Mawney Road',
            'postcode' => 'RM7 8BX',
            'geolocation' => new Point(51.583626,0.163757)
        ]);
        // subsequent businesses are not
        entity(Business::class)->create();
    }
}
