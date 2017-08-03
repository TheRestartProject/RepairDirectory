<?php

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

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
    $business = new Business();
    $business->setName($faker->name);
    $business->setAddress(implode(', ', explode("\n", $faker->address)));
    $business->setPostcode($faker->postcode);
    $business->setDescription($faker->sentence);
    $business->setGeolocation(new Point($faker->randomFloat(), $faker->randomFloat()));
    return $business;
});
