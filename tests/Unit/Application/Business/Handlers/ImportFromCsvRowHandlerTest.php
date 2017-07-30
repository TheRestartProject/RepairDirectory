<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Business\Handlers;

use TheRestartProject\RepairDirectory\Application\Business\Commands\ImportFromCsvRowCommand;
use TheRestartProject\RepairDirectory\Application\Business\Handlers\ImportFromCsvRowHandler;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use \Mockery as m;

/**
 * Test for the ImportFromCsvRowHandler class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromCsvRowHandlerTest extends TestCase
{
    /**
     * The Handler under test
     *
     * @var ImportFromCsvRowHandler
     */
    private $handler;

    /**
     * The mocked repository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * The mocked factory
     *
     * @var BusinessFactory
     */
    private $factory;

    /**
     * Setups the the handler under test for each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->repository = m::spy(BusinessRepository::class);
        $this->factory = m::mock(BusinessFactory::class);
        $this->handler = new ImportFromCsvRowHandler(
            $this->repository,
            $this->factory
        );
    }

    /**
     * Tests that it can be constructed
     *
     * This test confirms that the handler can be constructed with
     * the correct dependencies.
     *
     * @test
     *
     * @return void
     */
    public function it_can_be_constructed()
    {
        $handler = new ImportFromCsvRowHandler($this->repository, $this->factory);

        self::assertInstanceOf(ImportFromCsvRowHandler::class, $handler);
    }

    /**
     * Tests that the handler works
     *
     * Tests that the handler successfully converts a CSV row
     * into a Business using the factory and adds it to the
     * Repository.
     *
     * @test
     *
     * @return void
     */
    public function it_can_add_a_business_to_the_repository()
    {
        $csvRow = [];
        $this->setupFactory($csvRow);

        $addedBusiness = $this->handler->handle(new ImportFromCsvRowCommand($csvRow));

        $this->assertBusinessAdded($addedBusiness);
        self::assertInstanceOf(Business::class, $addedBusiness);
    }

    /**
     * Sets up the factory to turn a CSV row into a Business
     *
     * @param array $csvRow the array that represents a CSV row
     *
     * @return void
     */
    public function setupFactory(array $csvRow)
    {
        $business = new Business();
        $this->factory->shouldReceive('fromCsvRow')->with($csvRow)->andReturn($business);
    }

    /**
     * Asserts that the business was added to the repository
     *
     * @param Business $business the Business model that was added to the repository
     *
     * @return void
     */
    public function assertBusinessAdded($business)
    {
        $this->repository->shouldHaveReceived('add')
            ->with($business);
    }
}
