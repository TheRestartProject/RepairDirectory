<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Application\Validators\EmailValidator;
use TheRestartProject\RepairDirectory\Application\Validators\Validator;
use TheRestartProject\RepairDirectory\Tests\ValidationTestCase;

/**
 * Test class for the EmailValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class EmailValidatorTest extends ValidationTestCase
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
        $this->validator = new EmailValidator();
    }

    /**
     * Test the email validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_email_invalid()
    {
        try {
            $this->validator->validate('j@o.a');
            self::fail('Did not throw exception when email too short');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate($this->getRandomString(101));
            self::fail('Did not throw exception when email too long');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate('joaquim@com');
            self::fail('Did not throw exception when email invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate('joaquim.com');
            self::fail('Did not throw exception when email invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate('joaquim@out.re');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

}
