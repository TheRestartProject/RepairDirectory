<?php

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Models\Suggestion;

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
        $business->setPublishingStatus($faker->word);
    }

    $business->setCity($faker->city);
    $business->setWarrantyOffered(true);
    $business->setPositiveReviewPc(81);

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
