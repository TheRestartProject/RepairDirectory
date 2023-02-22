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
        entity(User::class)->create([
            'email' => 'root@restartproject.com',
            'role' => User::ROOT
        ]);

        entity(User::class)->create([
            'email' => 'admin@restartproject.com',
            'role' => User::ADMINISTRATOR
        ]);

        entity(User::class)->create([
            'email' => 'host@restartproject.com',
            'role' => User::HOST
        ]);

        entity(User::class)->create([
            'email' => 'restarter@restartproject.com',
            'role' => User::RESTARTER
        ]);

        entity(User::class)->create([
            'email' => 'guest@restartproject.com',
            'role' => User::GUEST
        ]);
    }
}
