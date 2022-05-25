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
     * @test
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
            'businesses',
            [
                'uid' => 1,
                'name' => $business->getName()
            ]
        );

        $businessRepository = $this->app->make(BusinessRepository::class);

        $this->assertEquals(new Point(51.3813963, -2.3613877), $businessRepository->findBusinessForUser(1, NULL, TRUE)->getGeolocation());
    }

    /**
     * Asserts that the BusinessController->update function updates an existing Business
     * and persists this in the database
     *
     * @return void
     *
     * @test
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
            'businesses',
            [
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
     * @return array
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
}
