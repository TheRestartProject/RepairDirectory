<?php

use Illuminate\Database\Seeder;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(Business::class)->create();
    }
}
