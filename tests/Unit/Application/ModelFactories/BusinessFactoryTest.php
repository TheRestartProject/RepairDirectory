<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Application\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Domain\Models\Point;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class BusinessFactoryTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\ModelFactories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessFactoryTest extends TestCase
{
    /**
     * The Factory under test
     *
     * @var BusinessFactory
     */
    private $factory;

    /**
     * The setup function run before each test
     *
     * @return void
     */
    public function setUp()
    {
        $this->factory = new BusinessFactory();
    }

    /**
     * Tests that it can create a simple business
     *
     * @return void
     *
     * @test
     */
    public function it_can_create_a_business_from_csv_row()
    {
        $row = $this->createTestRow();

        $business = $this->factory->fromCsvRow($row);
        $this->assertInstanceOf(Business::class, $business);
        $this->assertEquals(new Point(51.3813993, -2.363582), $business->getGeolocation());
        $this->assertEquals('iRepair Centre Bath', $business->getName());
        $this->assertEquals('Bath\'s iRepair Centre. Fix all your broken devices.', $business->getDescription());
        $this->assertEquals('12 Westgate St, Bath', $business->getAddress());
        $this->assertEquals('BA1 1EQ', $business->getPostcode());
        $this->assertEquals('01225 427538', $business->getLandline());
        $this->assertEquals('07700 900220', $business->getMobile());
        $this->assertEquals('http://irepaircentrebath.co.uk', $business->getWebsite());
        $this->assertEquals('Electronic gadgets', $business->getCategory());
        $this->assertEquals(['Phones'], $business->getProductsRepaired());
        $this->assertEquals(false, $business->isAuthorised());
        $this->assertEquals('BTEC', $business->getQualifications());
        $this->assertEquals(
            [
                'https://www.google.com/maps/place/iRepair+Centre+Bath/@51.3813993,-2.363582,17z/',
                'https://www.yell.com/biz/irepair-centre-bath-7943040/'
            ],
            $business->getReviews()
        );
        $this->assertEquals(92, $business->getPositiveReviewPc());
        $this->assertEquals('None', $business->getWarranty());
        $this->assertEquals('Varied', $business->getPricingInformation());
    }

    /**
     * Tests the parsing of the 'Authorised repairer' column
     *
     * @return void
     *
     * @test
     */
    public function it_can_parse_the_authorised_repairer_column()
    {
        $row = $this->createTestRow();
        $row['Authorised repairer'] = 'Yes';
        $business = $this->factory->fromCsvRow($row);
        $this->assertEquals(true, $business->isAuthorised());
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
            'Warranty offered' => 'None',
            'Pricing information' => 'Varied'
        ];
    }
}
