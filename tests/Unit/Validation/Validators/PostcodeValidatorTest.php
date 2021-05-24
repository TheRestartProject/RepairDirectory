<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Validation\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Validation\Validators\PostcodeValidator;
use TheRestartProject\RepairDirectory\Validation\Validators\Validator;
use TheRestartProject\RepairDirectory\Tests\Unit\Validation\ValidationTestCase;

/**
 * Test class for the PostcodeValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class PostcodeValidatorTest extends ValidationTestCase
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
    protected function setUp(): void
    {
        $this->validator = new PostcodeValidator();
    }

    /**
     * Test the postcode validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_postcode_invalid()
    {
        try {
            $this->validator->validate('a b');
            self::fail('Did not throw exception when postcode too short');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate('en22 66pj');
            self::fail('Did not throw exception when postcode too long');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate('en26pj');
            self::fail('Did not throw exception when postcode invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: must include a space', $e->getMessage());
        }

        try {
            $this->validator->validate('en2 6pj');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }
}
