<?php

// namespace Database\Factories;
namespace Database\Factories\TheRestartProject\Fixometer\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use TheRestartProject\Fixometer\Domain\Entities\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/



/** @var LaravelDoctrine\ORM\Testing\Factory $factory */

class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition_2()
    {
        static $password;

        $createdAt = $this->faker->dateTimeBetween('-10 days');

        $user = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password ?: $password = bcrypt('secret'),
            'name' => $this->faker->firstName(),
            'role' => User::GUEST,
            'recovery' => null,
            'recoveryExpires' => null,
            'createdAt' => $createdAt,
            'modifiedAt' => $createdAt
        ];

        return [ $user ];
    }
}
