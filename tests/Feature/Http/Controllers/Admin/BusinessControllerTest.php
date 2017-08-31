<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Admin;

use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Admin\BusinessController Test
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http\Controllers\Admin;
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class BusinessControllerTest extends IntegrationTestCase
{
    use DatabaseMigrations;
    use FixometerDatabaseMigrations;
    /**
     * Asserts that the BusinessController->create function creates a new Business
     * and persists this in the database
     *
     * @return void
     *
     * @todo: this doesn't its test elsewhere.
     */
    public function i_can_create()
    {
        $user = entity(User::class)->create(['role' => User::HOST]);
        $this->be($user);

        /**
         * The business to create
         *
         * @var Business $business
         */
        $business = entity(Business::class, 'real')->make();

        $response = $this->post(
            route('admin.business.create'),
            $this->convertBusinessToHttpData($business)
        );
        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'businesses', [
                'uid' => $business->getUid(),
            ]
        );

        $businessRepository = $this->app->make(BusinessRepository::class);

        $this->assertEquals(new Point(51.3813963, -2.3613877), $businessRepository->findById(7)->getGeolocation());
    }

    /**
     * Asserts that the BusinessController->update function updates an existing Business
     * and persists this in the database
     *
     * @return void
     *
     * @todo: this doesn't work its tested elsewhere
     */
    public function i_can_update()
    {
        $user = entity(User::class)->create(['role' => User::HOST]);
        $this->be($user);

        /**
         * The business to create
         *
         * @var Business $business
         */
        $business = entity(Business::class)->create();
        $business->setName('This is a new name');
        $business->setDescription('This is a new description.');

        $response = $this->put(
            route('admin.business.update', ['id' => $business->getUid()]),
            $this->convertBusinessToHttpData($business)
        );
        $response->assertStatus(302);

        $this->assertDatabaseHas(
            'businesses', [
                'uid' => 1,
                'name' => 'This is a new name',
                'description' => 'This is a new description.'
            ]
        );
    }

    /**
     * Converts a business into http data
     *
     * @param Business $business The business to convert
     *
     * @return data
     */
    protected function convertBusinessToHttpData(Business $business)
    {
        $data = $business->toArray();

        if (array_key_exists('warrantyOffered', $data)) {
            $data['warrantyOffered'] = 'Yes';
        }

        if (array_key_exists('productsRepaired', $data)) {
            $data['productsRepaired'] = '';
        }

        if (array_key_exists('authorisedBrands', $data)) {
            $data['authorisedBrands'] = '';
        }

        return $data;
    }

    /**
     * Tests that the scraping of reviews works (currently only for Google Places).
     *
     * @return void
     *
     * @test
     */
    public function i_can_scrape_review()
    {
        $user = entity(User::class)->create(['role' => User::HOST]);
        $this->be($user);
        $response = $this->get(
            route(
                'admin.business.scrape-review',
                [
                    'url' => 'https://www.google.co.uk/maps/place/KFC/@51.3963959,-2.4904243,12z/data=!4m8!1m2!2m1!1skfc!3m4!1s0x0:0xdf6f3803ac00dc83!8m2!3d51.3795758!4d-2.3584342'

                ]
            )
        );
        $response->assertStatus(200);
        $content = $response->decodeResponseJson();

        self::assertEquals(ReviewSource::GOOGLE, $content['reviewSource']);

        self::assertGreaterThan(2, $content['reviewAggregation']['averageScore']);
        self::assertLessThan(4, $content['reviewAggregation']['averageScore']);

        self::assertGreaterThan(40, $content['reviewAggregation']['positiveReviewPc']);
        self::assertLessThan(100, $content['reviewAggregation']['positiveReviewPc']);
    }
}
