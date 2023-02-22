<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        entity(Business::class)->create([
            'name' => 'Link Computer Services',
            'description' => 'PC repairs',
            'address' => '203 Mawney Road',
            'postcode' => 'RM7 8BX',
            'geolocation' => new Point(51.583626, 0.163757),
            'categories' => [Category::DESKTOP],
            'positiveReviewPc' => 82,
            'publishingStatus' => PublishingStatus::PUBLISHED,
            'warranty' => '3 year warranty'
        ]);

        entity(Business::class)->create([
            'name' => 'Link Laptop Services',
            'description' => 'Laptop repairs',
            'address' => '203 Mawney Road',
            'postcode' => 'RM7 8BX',
            'geolocation' => new Point(51.583626, 0.163757),
            'categories' => [Category::LAPTOP],
            'positiveReviewPc' => 82,
            'publishingStatus' => PublishingStatus::PUBLISHED,
            'warranty' => '3 year warranty'
        ]);

        entity(Business::class)->create([
            'name' => 'Khan Communication',
            'description' => 'Mobile phone shop',
            'address' => '7 Cranbrook Road, Ilford',
            'postcode' => 'IG1 4DU',
            'geolocation' => new Point(51.5589297, -0.1090134),
            'categories' => [Category::DESKTOP],
            'positiveReviewPc' => 81,
            'publishingStatus' => PublishingStatus::PUBLISHED,
            'warranty' => 'Yes'
        ]);

        entity(Business::class)->create([
            'positiveReviewPc' => 83,
            'publishingStatus' => PublishingStatus::PUBLISHED,
            'warranty' => 'Yes'
        ]);

        entity(Business::class)->create([
            'positiveReviewPc' => 83,
            'warranty' => 'Yes'
        ]);

        entity(Business::class)->create([
            'warranty' => 'Yes'
        ]);

        entity(Business::class)->create();
    }
}
