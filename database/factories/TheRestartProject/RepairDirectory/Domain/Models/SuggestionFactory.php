<?php

namespace Database\Factories\TheRestartProject\RepairDirectory\Domain\Models;

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

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */

class SuggestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'field' => $this->faker->word,
            'value' => $this->faker->word,
        ];
    }
}
