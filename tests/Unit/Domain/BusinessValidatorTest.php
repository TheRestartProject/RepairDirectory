<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Domain;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Services\BusinessValidator;
use TheRestartProject\RepairDirectory\Tests\TestCase;

class BusinessValidatorTest extends TestCase
{

    /** @var BusinessValidator */
    private $validator;

    public function setUp()
    {
        parent::setUp();
        $this->validator = new BusinessValidator();
    }

    /**
     * Test the name validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_name_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setName('a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when name too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Name invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setName($this->getRandomString(256));
            $this->validator->validate($business);
            self::fail('Did not throw exception when name too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Name invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setName('Joaquim');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the description validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_description_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setDescription('shortdesc');
            $this->validator->validate($business);
            self::fail('Did not throw exception when description too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Description invalid: must be at least 10 characters long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setDescription($this->getRandomString(65536));
            $this->validator->validate($business);
            self::fail('Did not throw exception when description too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Description invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setDescription('Repair all your gadgets!');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the address validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_address_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setAddress('a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when address too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setAddress($this->getRandomString(256));
            $this->validator->validate($business);
            self::fail('Did not throw exception when address too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setAddress('22 Fonthill Road');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
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
            $business = $this->createTestBusiness();
            $business->setPostcode('a b');
            $this->validator->validate($business);
            self::fail('Did not throw exception when postcode too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Postcode invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setPostcode('en22 66pj');
            $this->validator->validate($business);
            self::fail('Did not throw exception when postcode too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Postcode invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setPostcode('en226pj');
            $this->validator->validate($business);
            self::fail('Did not throw exception when postcode invalid');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Postcode invalid: must include a space', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setPostcode('en2 6pj');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the city validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_city_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setCity('a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when city too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('City invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setCity($this->getRandomString(101));
            $this->validator->validate($business);
            self::fail('Did not throw exception when city too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('City invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setCity('London');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the localArea validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_local_area_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setLocalArea('a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when localArea too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Local area invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setLocalArea($this->getRandomString(101));
            $this->validator->validate($business);
            self::fail('Did not throw exception when localArea too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Local area invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setLocalArea('Brixton');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the landline validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_landline_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setLandline('079hello46');
            $this->validator->validate($business);
            self::fail('Did not throw exception when landline not numeric');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Landline invalid: only numbers allowed', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setLandline('12345678');
            $this->validator->validate($business);
            self::fail('Did not throw exception when landline too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Landline invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setLandline('1234567890123456789012');
            $this->validator->validate($business);
            self::fail('Did not throw exception when landline too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Landline invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setLandline('07700123123');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the mobile validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_mobile_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setMobile('079hello46');
            $this->validator->validate($business);
            self::fail('Did not throw exception when mobile not numeric');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Mobile invalid: only numbers allowed', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setMobile('12345678');
            $this->validator->validate($business);
            self::fail('Did not throw exception when mobile too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Mobile invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setMobile('123456789012345678901');
            $this->validator->validate($business);
            self::fail('Did not throw exception when mobile too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Mobile invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setMobile('07700123123');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    /**
     * Test the website validation
     *
     * @test
     *
     * @return void
     */
    public function it_throws_a_validation_exception_when_website_invalid()
    {
        try {
            $business = $this->createTestBusiness();
            $business->setWebsite('o.re');
            $this->validator->validate($business);
            self::fail('Did not throw exception when website too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Website invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setWebsite($this->getRandomString(101));
            $this->validator->validate($business);
            self::fail('Did not throw exception when website too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Website invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setWebsite('joaquimcom');
            $this->validator->validate($business);
            self::fail('Did not throw exception when website invalid');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Website invalid: must include a domain', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setWebsite('joaquim.com');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
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
            $business = $this->createTestBusiness();
            $business->setEmail('j@o.a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when email too short');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Email invalid: too short', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setEmail($this->getRandomString(101));
            $this->validator->validate($business);
            self::fail('Did not throw exception when email too long');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Email invalid: too long', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setEmail('joaquim@com');
            $this->validator->validate($business);
            self::fail('Did not throw exception when email invalid');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setEmail('joaquim.com');
            $this->validator->validate($business);
            self::fail('Did not throw exception when email invalid');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setEmail('joaquim@o.re');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
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
            $business = $this->createTestBusiness();
            $business->setCategory('a');
            $this->validator->validate($business);
            self::fail('Did not throw exception when category unknown');
        } catch (BusinessValidationException $e) {
            self::assertEquals('Category invalid: unknown category', $e->getMessage());
        }

        try {
            $business = $this->createTestBusiness();
            $business->setCategory('Computers and Home Office');
            $this->validator->validate($business);
        } catch (BusinessValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

    private function createTestBusiness() {
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

    private function getRandomString($length) {
        $str = '';
        while ($length > 0) {
            $str .= chr(rand(65,90));
            $length--;
        }
        return $str;
    }

}