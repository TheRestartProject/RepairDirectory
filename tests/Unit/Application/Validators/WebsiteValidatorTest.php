<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Application\Validators\Validator;
use TheRestartProject\RepairDirectory\Application\Validators\WebsiteValidator;
use TheRestartProject\RepairDirectory\Tests\ValidationTestCase;

/**
 * Test class for the WebsiteValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class WebsiteValidatorTest extends ValidationTestCase
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
        $this->validator = new WebsiteValidator();
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
            $this->validator->validate('o.re');
            self::fail('Did not throw exception when website too short');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: must be between 5 and 100 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate($this->getRandomString(101));
            self::fail('Did not throw exception when website too long');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: must be between 5 and 100 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate('joaquimcom');
            self::fail('Did not throw exception when website invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate('joaquim.com');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

}
