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
     * Sets up the test environment
     */
    public function setUp()
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

        $business = $this->createInvalidBusiness();
        $data = $this->generateRequestDataFromBusiness($business);

        $command = new ImportFromHttpRequestCommand($data);

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

        $business = $this->createValidBusiness();
        $data = $this->generateRequestDataFromBusiness($business);

        $command = $this->createCommand($data);

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

        $this->logInAsRole(User::GUEST);

        $business = $this->createValidBusiness();
        $data = $this->generateRequestDataFromBusiness($business);

        $command = $this->createCommand($data);

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
        $business = $this->createValidBusiness();
        $business->setPublishingStatus(PublishingStatus::DRAFT);
        $data = $this->generateRequestDataFromBusiness($business);

        $this->logInAsRole(User::RESTARTER);

        $command = new ImportFromHttpRequestCommand($data);

        $this->bus->handle($command);

        $this->assertDatabaseHas('businesses', [
            'name' => $business->getName(),
            'publishing_status' => $business->getPublishingStatus()
        ]);
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
        $business = $this->createValidBusiness();
        $business->setPublishingStatus(PublishingStatus::DRAFT);
        $data = $this->generateRequestDataFromBusiness($business);

        $this->logInAsRole(User::RESTARTER);

        $command = new ImportFromHttpRequestCommand($data);

        $this->bus->handle($command);

        $this->assertDatabaseHas('businesses', [
            'name' => $business->getName(),
            'publishing_status' => $business->getPublishingStatus()
        ]);
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

        $this->logInAsRole(User::RESTARTER);

        $business = $this->createValidBusiness();
        $business->setPublishingStatus(PublishingStatus::PUBLISHED);
        $data = $this->generateRequestDataFromBusiness($business);

        $command = $this->createCommand($data);

        $this->bus->handle($command);
    }

    /**
     * Creates an invalid business
     *
     * @return Business
     */
    protected function createInvalidBusiness()
    {
        return entity(Business::class, 'invalid')->make();
    }

    /**
     * Creates an invalid business
     *
     * @return Business
     */
    protected function createValidBusiness()
    {
        return entity(Business::class)->make();
    }

    /**
     * @param Business $business The business to convert
     *
     * @return array
     */
    protected function generateRequestDataFromBusiness(Business $business)
    {
        $data = $business->toArray();

        $data['productsRepaired'] = implode(',', $business->getProductsRepaired());
        $data['authorisedBrands'] = implode(',', $business->getAuthorisedBrands());

        return $data;
    }

    /**
     * Creates a command to be tested
     *
     * @param $data
     *
     * @return ImportFromHttpRequestCommand
     */
    protected function createCommand($data)
    {
        return new ImportFromHttpRequestCommand($data);
    }

    /**
     * Log in as a user of a specific role
     *
     * @param string $role The role for the user that is to be logged in
     *
     * @return $this
     */
    protected function logInAsRole($role)
    {
        $user = entity(User::class)->create(['role' => $role]);
        $this->be($user);

        return $this;
    }
}
