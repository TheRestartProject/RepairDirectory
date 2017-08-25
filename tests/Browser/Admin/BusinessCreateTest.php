<?php

namespace TheRestartProject\RepairDirectory\Tests\Browser\Admin;

use Illuminate\Contracts\Auth\Authenticatable;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\BusinessListPage;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\CreateBusinessPage;
use TheRestartProject\RepairDirectory\Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use TheRestartProject\RepairDirectory\Tests\Browser\Pages\MapPage;

/**
 * Test class for the Admin Create Business functionality
 *
 * @category Tests
 * @package  TheRestartProject\RepairDirectory\Tests\Browser\Pages
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class BusinessCreateTest extends DuskTestCase
{
    use DatabaseMigrations, FixometerDatabaseMigrations;

    /**
     * Test that I need to be logged in to visit the create business page
     *
     * Given I am not logged in
     *  When I visit the create business page
     *  Then I should be redirected to the homepage
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_visit_the_create_business_page_if_not_logged_in()
    {
        $this->browse(
            function (Browser $browser) {
                $browser->visitRoute('admin.business.create')
                    ->assertRouteIs('home');
            }
        );
    }

    /**
     * Test that a guest cannot visit the admin section
     *
     * Given I am logged in as a guest
     *  When I visit the admin page
     *  Then I should be redirected to the homepage
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_visit_the_create_business_page_if_i_am_logged_in_as_a_guest()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::GUEST]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visitRoute('admin.business.create')
                    ->assertRouteIs('home');
            }
        );
    }

    /**
     * Tests that a restarter can visit the admin page
     *
     * Given I am logged in as a Restarter
     *  When I visit the admin page
     *  Then I should be on the admin page
     *
     * @test
     *
     * @return void
     */
    public function i_can_visit_the_create_business_page_if_i_am_logged_in_as_a_restarter()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visitRoute('admin.business.create')
                    ->assertRouteIs('admin.business.create');
            }
        );
    }

    /**
     * Test that a restarter can create a new draft business
     *
     * Given I am logged in as a restarter
     *  When I create a new draft business
     *  Then I should see that business in the list
     *
     * @test
     *
     * @return void
     */
    public function i_can_create_a_new_draft_business_if_i_am_logged_in_as_a_restarter()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $businessName = 'Name of Business';
                $browser->loginAs($user->getAuthIdentifier())
                    ->visit(new CreateBusinessPage())
                    ->fillInForm($businessName)
                    ->press('@submitButton')
                    ->assertRouteIs('admin.index')
                    ->assertSee($businessName);
            }
        );
    }


    /**
     * Test that a restarter can create a new ready for review business
     *
     * Given I am logged in as a restarter
     *  When I create a new ready for review business
     *  Then I should see that business in the list
     *
     * @test
     *
     * @return void
     */
    public function i_can_create_a_new_ready_for_review_business_if_i_am_logged_in_as_a_restarter()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $businessName = 'Name of Business';
                $browser->loginAs($user->getAuthIdentifier())
                    ->visit(new CreateBusinessPage())
                    ->fillInForm($businessName)
                    ->setPublishedStatusAs(PublishingStatus::READY_FOR_REVIEW)
                    ->press('@submitButton')
                    ->assertRouteIs('admin.index')
                    ->assertSee($businessName);
            }
        );
    }

    /**
     * Test that a restarter cannot create a new published business
     *
     * Given I am logged in as a restarter
     *  When I try to create a new business
     *  Then I cannot see the published status in the published status select input
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_new_published_business_if_i_am_logged_in_as_a_restarter()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visit(new CreateBusinessPage())
                    ->assertCannotSelectStatus(PublishingStatus::PUBLISHED);
            }
        );
    }

    /**
     * Test that a restarter cannot create a new hidden business
     *
     * Given I am logged in as a restarter
     *  When I try to create a new business
     *  Then I cannot see the hidden status in the published status select input
     *
     * @test
     *
     * @return void
     */
    public function i_cannot_create_a_new_hidden_business_if_i_am_logged_in_as_a_restarter()
    {
        /**
         * The user to log in with
         *
         * @var Authenticatable $user
         */
        $user = entity(User::class)->create(['role' => User::RESTARTER]);

        $this->browse(
            function (Browser $browser) use ($user) {
                $browser->loginAs($user->getAuthIdentifier())
                    ->visit(new CreateBusinessPage())
                    ->assertCannotSelectStatus(PublishingStatus::HIDDEN);
            }
        );
    }
}
