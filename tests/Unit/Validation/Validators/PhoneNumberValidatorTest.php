<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Validation\Validators\PhoneNumberValidator;
use TheRestartProject\RepairDirectory\Validation\Validators\Validator;
use TheRestartProject\RepairDirectory\Tests\Unit\Validation\ValidationTestCase;

/**
 * Test class for the PhoneNumberValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class PhoneNumberValidatorTest extends ValidationTestCase
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
        $this->validator = new PhoneNumberValidator('Landline');
    }

    /**
     * Test the phone number validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_phone_number_invalid()
    {
        try {
            $this->validator->validate('079hello46');
            self::fail('Did not throw exception when landline not numeric');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: only numbers allowed', $e->getMessage());
        }

        try {
            $this->validator->validate('12345678');
            self::fail('Did not throw exception when landline too short');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: must be between 10 and 20 numbers long', $e->getMessage());
        }

        try {
            $this->validator->validate('1234567890123456789012');
            self::fail('Did not throw exception when landline too long');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: must be between 10 and 20 numbers long', $e->getMessage());
        }

        try {
            $this->validator->validate('07700123123');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

}
