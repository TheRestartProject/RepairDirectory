<?php

namespace TheRestartProject\RepairDirectory\Tests\Integration\Application\Commands\Business\ImportFromHttpRequest;

use League\Tactician\CommandBus;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Testing\DatabaseMigrations;
use TheRestartProject\RepairDirectory\Testing\FixometerDatabaseMigrations;
use TheRestartProject\RepairDirectory\Tests\IntegrationTestCase;

/**
 * Class ImportFromHttpRequestCommandTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Integration\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ImportFromHttpRequestCommandTest extends IntegrationTestCase
{
    use DatabaseMigrations, FixometerDatabaseMigrations;

    /**
     * The tactician command bus
     *
     * @var CommandBus $bus
     */
    protected $bus;

    /**
     * The business to test with
     *
     * @var Business $business
     */
    protected $business;

    /**
     * Sets up the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = $this->app->make(CommandBus::class);
    }


    /**
     * Test that an invalid business cannot be imported
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_the_business_is_invalid()
    {
        $this->expectException(BusinessValidationException::class);

        $command = $this->makeInvalidBusiness()
            ->createCommand();

        $this->bus->handle($command);
    }

    /**
     * Tests that a user is required to import a business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_no_user_is_logged_in()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this->makeValidBusiness()
            ->createCommand();

        $this->bus->handle($command);
    }

    /**
     * Tests that a guest user cannot import a business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_the_user_is_a_guest()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this
            ->logInAsRole(User::GUEST)
            ->makeValidBusiness()
            ->createCommand();

        $this->bus->handle($command);
    }

    /**
     * Tests that a business can be successfully imported
     *
     * @test
     *
     * @return void
     */
    public function it_imports_the_draft_business_if_the_user_a_restarter()
    {
        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::DRAFT])
            ->createCommand();

        $this->bus->handle($command);

        $this->assertBusinessExists();
    }

    /**
     * Tests that a restarter can create a ready for review business
     *
     * @test
     *
     * @return void
     */
    public function it_imports_a_ready_for_review_business_if_the_user_is_a_restarter()
    {
        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::READY_FOR_REVIEW])
            ->createCommand();

        $this->bus->handle($command);

        $this->assertBusinessExists();
    }

    /**
     * Tests that a restarter cannot publish a business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_a_published_business_is_imported_by_a_restarter()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::PUBLISHED])
            ->createCommand();

        $this->bus->handle($command);
    }

    /**
     * Tests that a restart cannot import a hidden business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_exception_if_a_restarter_imports_a_hidden_business()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::HIDDEN])
            ->createCommand();

        $this->bus->handle($command);
    }

    /**
     * Test that an admin can import a published business
     *
     * @test
     *
     * @return void
     */
    public function it_imports_a_published_business_as_an_admin()
    {
        $command = $this
            ->logInAsRole(User::HOST)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::PUBLISHED])
            ->createCommand();

        $this->bus->handle($command);

        $this->assertBusinessExists();
    }

    /**
     * Test that an admin import a hidden business
     *
     * @test
     *
     * @return void
     */
    public function it_can_import_a_hidden_business_as_an_admin()
    {
        $command = $this
            ->logInAsRole(User::HOST)
            ->makeValidBusiness(['publishingStatus' => PublishingStatus::HIDDEN])
            ->createCommand();

        $this->bus->handle($command);

        $this->assertBusinessExists();
    }

    /**
     * Test that a restarter cannot update a published business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_error_if_a_restarter_tries_to_update_a_published_business()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::PUBLISHED])
            ->createCommand(
                [
                    'name' => 'New Name',
                    'publishingStatus' => PublishingStatus::DRAFT
                ]
            );

        $this->bus->handle($command);
    }

    /**
     * Test that a restarter cannot update a hidden business
     *
     * @test
     *
     * @return void
     */
    public function it_throws_an_error_if_a_restarter_tries_to_update_a_hidden_business()
    {
        $this->expectException(ImportBusinessUnauthorizedException::class);

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::HIDDEN])
            ->createCommand(
                [
                    'name' => 'New Name',
                    'publishingStatus' => PublishingStatus::DRAFT
                ]
            );

        $this->bus->handle($command);
    }

    /**
     * Test that a restarter can update a draft business
     *
     * @test
     *
     * @return void
     */
    public function it_allows_a_restarter_to_update_a_draft_business()
    {
        $newName = 'New Name';

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::DRAFT])
            ->createCommand(['name' => $newName]);

        $this->bus->handle($command);

        $this->assertBusinessExists(['name' => $newName]);
    }

    /**
     * Test that a restarter can update a ready for review  business
     *
     * @test
     *
     * @return void
     */
    public function it_allows_a_restarter_to_update_a_ready_to_review_business()
    {
        $newName = 'New Name';

        $command = $this
            ->logInAsRole(User::RESTARTER)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::READY_FOR_REVIEW])
            ->createCommand(['name' => $newName]);

        $this->bus->handle($command);

        $this->assertBusinessExists(['name' => $newName]);
    }

    /**
     * Test that a restarter can update a draft business
     *
     * @test
     *
     * @return void
     */
    public function it_allows_an_admin_to_update_a_published_business()
    {
        $newName = 'New Name';

        $command = $this
            ->logInAsRole(User::HOST)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::PUBLISHED])
            ->createCommand(['name' => $newName]);

        $this->bus->handle($command);

        $this->assertBusinessExists(['name' => $newName]);
    }

    /**
     * Test that a restarter can update a ready for review  business
     *
     * @test
     *
     * @return void
     */
    public function it_allows_an_admin_to_update_a_hidden_business()
    {
        $newName = 'New Name';

        $command = $this
            ->logInAsRole(User::HOST)
            ->createValidBusiness(['publishingStatus' => PublishingStatus::HIDDEN])
            ->createCommand(['name' => $newName]);

        $this->bus->handle($command);

        $this->assertBusinessExists(['name' => $newName]);
    }

    /**
     * Creates an invalid business
     *
     * @return $this
     */
    protected function makeInvalidBusiness()
    {
        $this->business = entity(Business::class, 'invalid')->make();

        return $this;
    }

    /**
     * Creates an invalid business
     *
     * @param array $attributes The array of attributes to create the business with
     *
     * @return $this
     */
    protected function makeValidBusiness(array $attributes = [])
    {
        $this->business = entity(Business::class)->make($attributes);

        return $this;
    }

    /**
     * Creates an invalid business
     *
     * @param array $attributes The array of attributes to create the business
     *
     * @return $this
     */
    protected function createValidBusiness(array $attributes = [])
    {
        $this->business = entity(Business::class)->create($attributes);

        return $this;
    }

    /**
     * Generates request data from a business
     *
     * @param Business $business  The business to convert
     * @param array    $overrides An array of overrides
     *
     * @return array
     */
    protected function generateRequestDataFromBusiness(Business $business, array $overrides = [])
    {
        $data = array_merge($business->toArray(), $overrides);

        return $data;
    }

    /**
     * Creates a command to be tested
     *
     * @param array $overrides Overrides the data that is used to setup the database
     *
     * @return ImportFromHttpRequestCommand
     */
    protected function createCommand(array $overrides = [])
    {
        $data = $this->generateRequestDataFromBusiness($this->business);

        $data = array_merge($data, $overrides);

        return new ImportFromHttpRequestCommand($data, $this->business->getUid());
    }

    /**
     * Log in as a user of a specific role
     *
     * @param int $role The role for the user that is to be logged in
     *
     * @return $this
     */
    protected function logInAsRole($role)
    {
        $user = entity(User::class)->create(['role' => $role]);
        $this->be($user);

        return $this;
    }

    /**
     * Asserts the business exists in the database
     *
     * @param array $overrides Array of attributes to override the assertion with
     *
     * @return $this;
     */
    protected function assertBusinessExists(array $overrides = [])
    {
        $data = array_merge(
            [
                'name' => $this->business->getName(),
                'publishing_status' => $this->business->getPublishingStatus()
            ],
            $overrides
        );

        $this->assertDatabaseHas('businesses', $data);

        return $this;
    }
}
