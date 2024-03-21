<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TheRestartProject\Fixometer\Domain\Entities\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->create([
            'email' => 'root@restartproject.com',
            'role' => User::ROOT
        ]);

        User::factory()->create([
            'email' => 'admin@restartproject.com',
            'role' => User::ADMINISTRATOR
        ]);

        User::factory()->create([
            'email' => 'host@restartproject.com',
            'role' => User::HOST
        ]);

        User::factory()->create([
            'email' => 'restarter@restartproject.com',
            'role' => User::RESTARTER
        ]);

        User::factory()->create([
            'email' => 'guest@restartproject.com',
            'role' => User::GUEST
        ]);

    }

}
