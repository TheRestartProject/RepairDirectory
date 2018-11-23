<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Util;

use TheRestartProject\RepairDirectory\Application\Util\AddressUtil;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class AddressUtilTest
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Infrastructure\ModelFactories
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class AddressUtilTest extends TestCase
{
    /**
     * Tests the parsing of the 'Address' column when there is a comma between City and Postcode
     *
     * @return void
     *
     * @test
     */
    public function it_can_parse_separated_addresses()
    {
        $addressStr = '12 Westgate St, Bath, BA1 1EQ';
        $parsedAddress = AddressUtil::parseUKAddress($addressStr);

        $this->assertEquals('12 Westgate St', $parsedAddress['address']);
        $this->assertEquals('BA1 1EQ', $parsedAddress['postcode']);
        $this->assertEquals('Bath', $parsedAddress['city']);
    }

    /**
     * Tests the parsing of the 'Address' column when there is not a comma between City and Postcode
     *
     * @return void
     *
     * @test
     */
    public function it_can_parse_unseparated_addresses()
    {
        $addressStr = '12 Westgate St, Bath BA1 1EQ';
        $parsedAddress = AddressUtil::parseUKAddress($addressStr);

        $this->assertEquals('12 Westgate St', $parsedAddress['address']);
        $this->assertEquals('BA1 1EQ', $parsedAddress['postcode']);
        $this->assertEquals('Bath', $parsedAddress['city']);
    }
}
