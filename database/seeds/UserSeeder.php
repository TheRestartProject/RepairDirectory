<?php

use Illuminate\Database\Seeder;
use TheRestartProject\RepairDirectory\Domain\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(User::class)->create([
            'email' => 'matt@outlandish.com',
            'password' => bcrypt('password')
        ]);
    }
}
