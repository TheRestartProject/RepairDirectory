<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\ModelFactories;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class BusinessFactoryTest
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\ModelFactories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessFactoryTest extends TestCase
{
    /**
     * Test BusinessFactoryTest::fromCsvRow
     *
     * @return void
     *
     * @test
     */
    public function testFromCsvRow()
    {
        $row = [
            'Name' => 'iRepair Centre Bath',
            'Address' => '12 Westgate St, Bath',
            'Postcode' => 'BA1 1EQ'
        ];
        $business = BusinessFactory::fromCsvRow($row);
        $this->assertInstanceOf(Business::class, $business);
        $this->assertEquals('iRepair Centre Bath', $business->getName());
        $this->assertEquals('12 Westgate St, Bath', $business->getAddress());
        $this->assertEquals('BA1 1EQ', $business->getPostcode());
    }
}
