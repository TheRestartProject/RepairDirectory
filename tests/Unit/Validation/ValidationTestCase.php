<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Validation;

use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Class ValidationTestCase
 *
 * Superclass for all validation tests.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Tests
 * @author   Matt Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
abstract class ValidationTestCase extends TestCase
{
    /**
     * Returns a random string
     *
     * @param integer $length How long the string should be
     *
     * @return string
     */
    protected function getRandomString($length)
    {
        $str = '';
        while ($length > 0) {
            $str .= chr(rand(65, 90));
            $length--;
        }
        return $str;
    }
}
