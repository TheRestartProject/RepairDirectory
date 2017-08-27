<?php

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
$factory->define(Business::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'address' => '12 Westgate St, Bath',
        'postcode' => 'BA1 1EQ',
        'city' => 'Bath',
        'description' => $faker->sentence,
        'geolocation' => new Point($faker->randomFloat(), $faker->randomFloat()),
        'categories' => ['Fan'],
        'publishingStatus' => PublishingStatus::DRAFT,
        'warrantyOffered' => true,
        'warranty' => $faker->sentence,
        'positiveReviewPc' => 80,
    ];
});

$factory->defineAs(Business::class, 'invalid', function (Faker\Generator $faker) {
    return [
        'name' => 'a',
        'description' => 'abcd',
        'address' => 'a',
        'postcode' => $faker->sentence(50, false),
        'city' => 'a',
        'localArea' => 'a',
        'landline' => 'abcd',
        'mobile' => 'abcd',
        'website' => 'abcd',
        'email' => 'abcd',
        'categories' => ['nothing'],
        'qualifications' => $faker->sentence(50, false),
        'communityEndorsement' => $faker->sentence(50, false),
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

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(Suggestion::class, function (Faker\Generator $faker) {

    return [
        'field' => $faker->word,
        'value' => $faker->word,
    ];
});

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    $createdAt = $faker->dateTimeBetween('-10 days');

    $user = [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'name' => $faker->firstName,
        'role' => User::GUEST,
        'recovery' => null,
        'recoveryExpires' => null,
        'createdAt' => $createdAt,
        'modifiedAt' => $createdAt
    ];

    return $user;
});

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(FixometerSession::class, function (Faker\Generator $faker) {
    $createdAt = $faker->dateTimeBetween('-10 days');

    return [
        'session' => $faker->unique()->lexify('?????????????'),
        'user' => $faker->randomDigitNotNull,
        'createdAt' => $createdAt,
        'modifiedAt' => $createdAt
    ];
});
