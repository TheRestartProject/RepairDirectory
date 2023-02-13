<?php

namespace Database\Factories\TheRestartProject\Fixometer\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\Factory;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\Fixometer\Domain\Entities\User;

/*
|--------------------------------------------------------------------------
| Entity Factories
|--------------------------------------------------------------------------
|
| Laravel Doctrine provides Entity Factories, which are similar to Laravel's Model Factories.
| These allow you to define values for each property of your Entities,
| and quickly generate many of them.
|
*/

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */

class FixometerSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $createdAt = $this->faker->dateTimeBetween('-10 days');

        return [
            'session' => $this->faker->unique()->lexify('?????????????'),
            'user' => $this->faker->randomDigitNotNull(),
            'createdAt' => $createdAt,
            'modifiedAt' => $createdAt
        ];
    }
}
