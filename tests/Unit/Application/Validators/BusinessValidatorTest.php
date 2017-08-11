<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Validators\BusinessValidator;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Tests\TestCase;

/**
 * Test class for the BusinessValidator class
 *
 * Checks validations are working correctly
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class BusinessValidatorTest extends TestCase
{

    /**
     * The validator under test
     *
     * @var BusinessValidator
     */
    private $validator;

    /**
     * Set up the test by creating a validator
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->validator = new BusinessValidator();
    }

    /**
     * Test the business validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_fields_are_missing()
    {
        $business = new Business();
        try {
            $this->validator->validate($business);
            self::fail('Did not throw exception when fields are missing');
        } catch (BusinessValidationException $e) {
            self::assertEquals(
                'name is required, address is required, postcode is required, description is required',
                $e->getMessage()
            );
            self::assertEquals(
                [
                    'name' => 'name is required',
                    'address' => 'address is required',
                    'postcode' => 'postcode is required',
                    'description' => 'description is required'
                ],
                $e->getErrors()
            );
            self::assertEquals($business, $e->getBusiness());
        }
    }

    /**
     * Test the business validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_fields_are_invalid()
    {
        $business = $this->createTestBusiness();
        try {
            $business->setName('a');
            $business->setLandline('abc');
            $this->validator->validate($business);
            self::fail('Did not throw exception when name too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals(
                'Name invalid: must be between 2 and 255 characters long, ' .
                'Landline invalid: only numbers allowed', $e->getMessage()
            );
            self::assertEquals(
                [
                    'name' => 'Name invalid: must be between 2 and 255 characters long',
                    'landline' => 'Landline invalid: only numbers allowed'
                ],
                $e->getErrors()
            );
            self::assertEquals($business, $e->getBusiness());
        }
    }

    /**
     * Returns a fresh and minimally valid business
     *
     * @return Business
     */
    private function createTestBusiness()
    {
        $business = new Business();
        $values = [
            "name" => 'Link Computer Services',
            "address" => "203 Mawney Road",
            "postcode" => "RM7 8BX",
            "description" => "Laptop, PC, and Netbook repairs, mobile service."
        ];
        foreach ($values as $key => $value) {
            $business->{'set' . ucfirst($key)}($value);
        }
        return $business;
    }


}
