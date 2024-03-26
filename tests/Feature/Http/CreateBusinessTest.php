<?php

namespace TheRestartProject\RepairDirectory\Tests\Feature\Http;

use Illuminate\Contracts\Session\Session;
use Illuminate\Testing\TestResponse;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Tests the ability to create new businesses
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Feature\Http
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class CreateBusinessTest extends IntegrationTestCase
{
    use DatabaseMigrations, FixometerDatabaseMigrations;

    /**
     * Test that a business cannot created by user that is not logged in
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_business_if_i_am_not_logged_in()
    {
        $business = entity(Business::class, 'real')->make();
        $this->createBusiness($business)
            ->assertRedirect(route('home'));
    }

    /**
     * Test that a business cannot created by guest
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_business_if_i_am_logged_in_as_a_guest()
    {
        $business = entity(Business::class, 'real')->make();

        $this->beRole(User::GUEST)
            ->createBusiness($business)
            ->assertRedirect(route('home'));
    }

    /**
     * Test that a draft business can be created by a restarter
     *
     * @test
     *
     * @return void
     */
    public function i_can_create_a_draft_business_as_a_restarter()
    {
        /**
         * The business to be created
         *
         * @var Business $business
         */
        $business = entity(Business::class, 'real')->make(
            [
                'publishingStatus' => PublishingStatus::DRAFT
            ]
        );

        $this->beRestarter()
            ->createBusiness($business);

        $this->assertBusinessExists($business);
    }

    /**
     * Test that a ready for review business can be created by a restarter
     *
     * @test
     *
     * @return void
     */
    public function i_can_create_a_ready_for_review_business_as_a_restarter()
    {
        /**
         * The business to be created
         *
         * @var Business $business
         */
        $business = entity(Business::class, 'real')->make(
            [
                'publishingStatus' => PublishingStatus::READY_FOR_REVIEW
            ]
        );

        $this->beRestarter()
            ->createBusiness($business);

        $this->assertBusinessExists($business);
    }

    /**
     * Test that a published business cannot be created by a restarter
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_published_business_as_a_restarter()
    {
        /**
         * Business to be created
         *
         * @var Business $business
         */
        $business = entity(Business::class, 'real')->make(
            [
                'publishingStatus' => PublishingStatus::PUBLISHED
            ]
        );

        $this->beRestarter()
            ->createBusiness($business)
            ->assertRedirect(route('admin.business.edit'));

        $this->assertBusinessDoesNotExist($business);
    }

    /**
     * Asserts that the business exists
     *
     * @param Business $business Business to be checked
     *
     * @return $this
     */
    protected function assertBusinessExists(Business $business)
    {
        $data = [
            'name' => $business->getName(),
            'publishing_status' => $business->getPublishingStatus()
        ];

        $this->assertDatabaseHas('businesses', $data);

        return $this;
    }

    /**
     * Asserts that the business exists
     *
     * @param Business $business Business to be checked with
     *
     * @return $this
     */
    protected function assertBusinessDoesNotExist(Business $business)
    {
        $data = [
            'name' => $business->getName(),
            'publishing_status' => $business->getPublishingStatus()
        ];

        $this->assertDatabaseMissing('businesses', $data);

        return $this;
    }


    /**
     * Log in as an Admin
     *
     * @return $this
     */
    protected function beAdmin()
    {
        return $this->beRole(User::GUEST);
    }

    /**
     * Log in as a Restarter
     *
     * @return $this
     */
    protected function beRestarter()
    {
        return $this->beRole(User::RESTARTER);
    }

    /**
     * Log in as a user of the specified role
     *
     * @param int $role The role that the user should be
     *
     * @return $this
     */
    protected function beRole($role)
    {
        $user = entity(User::class)->create(['role' => $role]);

        $this->be($user);

        return $this;
    }

    /**
     * Create a business by posting a serialized representation of one
     *
     * @param Business $business Business to fill in the form with
     *
     * @return TestResponse
     */
    protected function createBusiness(Business $business)
    {
        /**
         * The session object
         *
         * @var Session $session
         */
        $session = $this->app->make('session');

        $this->startSession();

        return $this->post(
            route('admin.business.create'),
            array_merge(
                $this->serializeBusiness($business),
                ['_token', $session->token()]
            )
        );
    }

    /**
     * Converts a business into an array that can be used to fill in a form
     *
     * @param Business $business The business to serialize
     *
     * @return array
     */
    protected function serializeBusiness(Business $business)
    {
        return [
            'name' => $business->getName(),
            'address' => $business->getAddress(),
            'city' => $business->getCity(),
            'postcode' => $business->getPostcode(),
            'description' => $business->getDescription(),
            'landline' => $business->getLandline(),
            'mobile' => $business->getMobile(),
            'website' => $business->getWebsite(),
            'email' => $business->getEmail(),
            'categories' => $business->getCategories(),
            'productsRepaired' => implode(',', $business->getProductsRepaired()),
            'authorisedBrands' => implode(',', $business->getAuthorisedBrands()),
            'qualifications' => $business->getQualifications(),
            'communityEndorsement' => $business->getCommunityEndorsement(),
            'notes' => $business->getNotes(),
            'genericField1' => $business->getGenericField1(),
            'reviewSourceUrl' => $business->getReviewSourceUrl(),
            'positiveReviewPc' => $business->getPositiveReviewPc(),
            'reviewSource' => $business->getReviewSource(),
            'numberOfReviews' => $business->getNumberOfReviews(),
            'averageScore' => $business->getAverageScore(),
            'warrantyOffered' => $business->isWarrantyOffered() ? 'Yes' : 'No',
            'warranty' => $business->getWarranty(),
            'publishingStatus' => $business->getPublishingStatus()
        ];
    }
}
