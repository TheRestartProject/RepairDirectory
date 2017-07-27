<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;
use TheRestartProject\RepairDirectory\Tests\TestCase;


class BusinessFactoryTest extends TestCase
{
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
