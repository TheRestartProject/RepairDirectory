<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;
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
        $row = [
            'Name' => 'iRepair Centre Bath',
            'Address' => '12 Westgate St, Bath',
            'Postcode' => 'BA1 1EQ'
        ];
        $business = $this->factory->fromCsvRow($row);
        $this->assertInstanceOf(Business::class, $business);
        $this->assertEquals('iRepair Centre Bath', $business->getName());
        $this->assertEquals('12 Westgate St, Bath', $business->getAddress());
        $this->assertEquals('BA1 1EQ', $business->getPostcode());
    }
}
