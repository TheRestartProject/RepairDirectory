<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Commands;

use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow\ImportFromCsvRowCommand;
use TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow\ImportFromCsvRowHandler;
use TheRestartProject\RepairDirectory\Domain\Enums\ReviewSource;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Application\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use \Mockery as m;

/**
 * Test for the ImportFromCsvRow command
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromCsvRowTest extends TestCase
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
     * @var m\MockInterface
     */
    private $repository;

    /**
     * Setups the the handler under test for each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->repository = m::spy(BusinessRepository::class);

        /**
         * Cast mock to BusinessRepository
         *
         * @var BusinessRepository $repository
         */
        $repository = $this->repository;

        $this->handler = new ImportFromCsvRowHandler(
            $repository
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

        $handler = new ImportFromCsvRowHandler($repository);
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
        $csvRow = $this->createTestRow();

        $business = $this->handler->handle(new ImportFromCsvRowCommand($csvRow));

        $this->assertBusinessAdded($business);
        self::assertInstanceOf(Business::class, $business);
        $this->assertEquals(new Point(51.3813993, -2.363582), $business->getGeolocation());
        $this->assertEquals('iRepair Centre Bath', $business->getName());
        $this->assertEquals('Bath\'s iRepair Centre. Fix all your broken devices.', $business->getDescription());
        $this->assertEquals('12 Westgate St', $business->getAddress());
        $this->assertEquals('BA1 1EQ', $business->getPostcode());
        $this->assertEquals('Bath', $business->getCity());
        $this->assertEquals('Bath', $business->getLocalArea());
        $this->assertEquals('01225 427538', $business->getLandline());
        $this->assertEquals('07700 900220', $business->getMobile());
        $this->assertEquals('http://irepaircentrebath.co.uk', $business->getWebsite());
        $this->assertEquals(
            [
                'Apple iPhone',
                'Apple iPad',
                'Digital Camera',
                'Video Camera',
                'Handheld entertainment device',
                'Headphones',
                'Mobile/Smartphone',
                'PC Accessory',
                'Portable radio',
                'Tablet'
            ], $business->getCategories()
        );
        $this->assertEquals(['Phones'], $business->getProductsRepaired());
        $this->assertEquals([], $business->getAuthorisedBrands());
        $this->assertEquals('BTEC', $business->getQualifications());
        $this->assertEquals(
            ReviewSource::GOOGLE,
            $business->getReviewSource()
        );
        $this->assertEquals(92, $business->getPositiveReviewPc());
        $this->assertEquals('3 years', $business->getWarranty());
        $this->assertTrue($business->isWarrantyOffered());
        $this->assertEquals('Varied', $business->getPricingInformation());
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

    /**
     * Return a row with the structure expected from the CSV parser and data files
     *
     * @return array
     */
    private function createTestRow()
    {
        return [
            'Geolocation' => '51.3813993,-2.363582',
            'Name' => 'iRepair Centre Bath',
            'Description' => 'Bath\'s iRepair Centre. Fix all your broken devices.',
            'Address' => '12 Westgate St, Bath, BA1 1EQ',
            'Borough' => 'Bath',
            'Landline' => '01225 427538',
            'Mobile' => '07700 900220',
            'Website' => 'http://irepaircentrebath.co.uk',
            'Email' => '',
            'Category' => 'Electronic gadgets',
            'Products repaired' => 'Phones',
            'Authorised repairer' => 'No',
            'Qualifications' => 'BTEC',
            'Independent review link' => 'https://www.google.com/maps/place/iRepair+Centre+Bath/@51.3813993,-2.363582,17z/',
            'Other review link' => 'https://www.yell.com/biz/irepair-centre-bath-7943040/',
            'Positive review %' => '92',
            'Warranty offered' => '3 years',
            'Pricing information' => 'Varied'
        ];
    }
}
