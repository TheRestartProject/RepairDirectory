<?php

use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\FixometerSession;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;
use TheRestartProject\RepairDirectory\Domain\Models\User;

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
$factory->define(Business::class, function (Faker\Generator $faker, $attributes) {
    $business = new Business();

    if (array_key_exists('name', $attributes)) {
        $business->setName($attributes['name']);
    } else {
        $business->setName($faker->name);
    }

    if (array_key_exists('description', $attributes)) {
        $business->setDescription($attributes['description']);
    } else {
        $business->setDescription($faker->sentence);
    }

    if (array_key_exists('address', $attributes)) {
        $business->setAddress($attributes['address']);
    } else {
        $business->setAddress(implode(', ', explode("\n", $faker->address)));
    }

    $business->setCity($faker->city);

    if (array_key_exists('postcode', $attributes)) {
        $business->setPostcode($attributes['postcode']);
    } else {
        $business->setPostcode($faker->postcode);
    }

    if (array_key_exists('geolocation', $attributes)) {
        $business->setGeolocation($attributes['geolocation']);
    } else {
        $business->setGeolocation(new Point($faker->randomFloat(), $faker->randomFloat()));
    }
    if (array_key_exists('categories', $attributes)) {
        $business->setCategories($attributes['categories']);
    } else {
        $business->setCategories([$faker->sentence]);
    }

    if (array_key_exists('publishingStatus', $attributes)) {
        $business->setPublishingStatus($attributes['publishingStatus']);
    } else {
        $business->setPublishingStatus(PublishingStatus::DRAFT);
    }

    if (array_key_exists('warranty', $attributes)) {
        $business->setWarranty($attributes['warranty']);
        $business->setWarrantyOffered((boolean)$attributes['warranty']);
    }

    if (array_key_exists('positiveReviewPc', $attributes)) {
        $business->setPositiveReviewPc($attributes['positiveReviewPc']);
    } else {
        $business->setPositiveReviewPc(50);
    }

    return $business;
});

/** @var LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(Suggestion::class, function (Faker\Generator $faker, $attributes) {
    $suggestion = new Suggestion();

    if (array_key_exists('field', $attributes)) {
        $suggestion->setField($attributes['field']);
    } else {
        $suggestion->setField($faker->word);
    }

    if (array_key_exists('value', $attributes)) {
        $suggestion->setValue($attributes['value']);
    } else {
        $suggestion->setValue($faker->word);
    }

    return $suggestion;
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
