<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Commands;

use Illuminate\Http\Request;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestCommand;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest\ImportFromHttpRequestHandler;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessGeocoder;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use \Mockery as m;

/**
 * Test for the CreateFromHttpRequestTest command
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestTest extends TestCase
{
    /**
     * The Handler under test
     *
     * @var ImportFromHttpRequestHandler
     */
    private $handler;

    /**
     * The mocked repository
     *
     * @var m\MockInterface
     */
    private $repository;

    /**
     * The mocked factory
     *
     * @var m\MockInterface
     */
    private $factory;

    /**
     * The mocked Geocoder
     *
     * @var m\MockInterface
     */
    private $geocoder;

    /**
     * Setups the the handler under test for each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->repository = m::spy(BusinessRepository::class);
        $this->factory = m::mock(BusinessFactory::class);
        $this->geocoder = m::mock(BusinessGeocoder::class);

        /**
         * Cast mock to BusinessRepository
         *
         * @var BusinessRepository $repository
         */
        $repository = $this->repository;

        /**
         * Cast mock to BusinessFactory
         *
         * @var BusinessFactory $factory
         */
        $factory = $this->factory;

        /**
         * Cast mock to Geocoder
         *
         * @var BusinessGeocoder $geocoder
         */
        $geocoder = $this->geocoder;

        $this->handler = new ImportFromHttpRequestHandler(
            $repository,
            $factory,
            $geocoder
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
        /**
         * Cast mock to BusinessRepository
         *
         * @var BusinessRepository $repository
         */
        $repository = m::spy(BusinessRepository::class);

        /**
         * Cast mock to BusinessFactory
         *
         * @var BusinessFactory $factory
         */
        $factory = m::mock(BusinessFactory::class);

        /**
         * Cast mock to Geocoder
         *
         * @var BusinessGeocoder $geocoder
         */
        $geocoder = m::mock(BusinessGeocoder::class);

        $handler = new ImportFromHttpRequestHandler(
            $repository,
            $factory,
            $geocoder
        );
        self::assertInstanceOf(ImportFromHttpRequestHandler::class, $handler);
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
        $request = new Request();
        $this->setupFactory($request);
        $this->setupGeocoder();

        $addedBusiness = $this->handler->handle(new ImportFromHttpRequestCommand($request));

        $this->assertBusinessAdded($addedBusiness);
        self::assertInstanceOf(Business::class, $addedBusiness);
    }

    /**
     * Sets up the factory to turn a CSV row into a Business
     *
     * @param Request $request the request with Business data
     *
     * @return void
     */
    public function setupFactory($request)
    {
        $business = new Business();
        $this->factory->shouldReceive('fromHttpRequest')->with($request)->andReturn($business);
    }

    /**
     * Sets up the geocoder to return a [lat, lng] for a Business
     *
     * @param Request $request the request with Business data
     *
     * @return void
     */
    public function setupGeocoder()
    {
        $this->geocoder->shouldReceive('geocode')->andReturn([0, 0]);
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
