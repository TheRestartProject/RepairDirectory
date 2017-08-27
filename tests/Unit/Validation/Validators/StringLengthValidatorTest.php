<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Validation\Validators\StringLengthValidator;
use TheRestartProject\RepairDirectory\Validation\Validators\Validator;
use TheRestartProject\RepairDirectory\Tests\Unit\Validation\ValidationTestCase;

/**
 * Test class for the StringLengthValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class StringLengthValidatorTest extends ValidationTestCase
{

    /**
     * The validator under test
     *
     * @var Validator
     */
    private $validator;

    /**
     * Set up the test by creating the appropriate validator
     *
     * @return void
     */
    public function setUp() 
    {
        $this->validator = new StringLengthValidator('Address', 2, 255);
    }

    /**
     * Test the category validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_category_invalid()
    {
        try {
            $this->validator->validate('a');
            self::fail('Did not throw exception when string too short');
        } catch (ValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate($this->getRandomString(256));
            self::fail('Did not throw exception when string too long');
        } catch (ValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate('22 Fonthill Road');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

}
