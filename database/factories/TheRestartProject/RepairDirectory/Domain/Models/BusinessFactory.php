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

class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->unique()->address(),
            'postcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'description' => $this->faker->sentence(),
            'geolocation' => new Point($this->faker->randomFloat(), $this->faker->randomFloat()),
            'categories' => ['Fan'],
            'publishingStatus' => PublishingStatus::DRAFT,
            'warrantyOffered' => true,
            'warranty' => $this->faker->sentence(),
            'positiveReviewPc' => 80,
            'localArea' => $this->faker->words(2, true),
            'landline' => '077657784333',
            'mobile' => '077657784333',
            'website' => $this->faker->url(),
            'email' => $this->faker->companyEmail(),
            'qualifications' => $this->faker->sentence(),
            'communityEndorsement' => $this->faker->sentence(),
            'notes' => $this->faker->sentence()
        ];
    }

    public function invalid()
    {
        return $this->state(function () {
            return [
                'name' => 'a',
                'description' => 'abcd',
                'address' => 'a',
                'postcode' => $this->faker->sentence(50, false),
                'city' => 'a',
                'localArea' => 'a',
                'landline' => 'abcd',
                'mobile' => 'abcd',
                'website' => 'abcd',
                'email' => 'abcd',
                'categories' => ['nothing'],
                'qualifications' => $this->faker->sentence(50, false),
                'communityEndorsement' => $this->faker->sentence(50, false),
                'notes' => null,
                'reviewSource' => 'abcd',
                'positiveReviewPc' => -10,
                'numberOfReviews' => -10,
                'averageScore' => -1,
                'warrantyOffered' => 'abcd',
                'warranty' => 'abcd',
                'publishingStatus' => 'abcd'
            ];
        });
    }

    public function real()
    {
        return $this->state(function () {
            return [
                'name' => $this->faker->company(),
                'address' => '12 Westgate St, Bath',
                'postcode' => 'BA1 1EQ',
                'city' => 'Bath',
                'description' => $this->faker->sentence(),
                'categories' => ['Fan'],
                'publishingStatus' => PublishingStatus::DRAFT,
                'warrantyOffered' => true,
                'warranty' => $this->faker->sentence(),
                'positiveReviewPc' => 80,
                'localArea' => $this->faker->words(2, true),
                'landline' => '077657784333',
                'mobile' => '077657784333',
                'website' => $this->faker->domainName(),
                'email' => $this->faker->companyEmail(),
                'qualifications' => $this->faker->sentence(),
                'communityEndorsement' => $this->faker->sentence(),
                'notes' => $this->faker->sentence()
            ];
        });
    }
}
