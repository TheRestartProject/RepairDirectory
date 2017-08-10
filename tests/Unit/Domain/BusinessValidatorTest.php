<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Domain;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
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
            $this->validator->validate([
                'name' => 'a',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service."
            ]);
            self::fail('Did not throw exception when name too short');
        } catch (ValidationException $e) {
            self::assertEquals('Name invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => $this->getRandomString(256),
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service."
            ]);
            self::fail('Did not throw exception when name too long');
        } catch (ValidationException $e) {
            self::assertEquals('Name invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service."
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                'description' => 'abcdefghi'
            ]);
            self::fail('Did not throw exception when description too short');
        } catch (ValidationException $e) {
            self::assertEquals('Description invalid: must be at least 10 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                'description' => $this->getRandomString(65536)
            ]);
            self::fail('Did not throw exception when description too long');
        } catch (ValidationException $e) {
            self::assertEquals('Description invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                'description' => 'Some description'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'joaquim',
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'address' => 'a'
            ]);
            self::fail('Did not throw exception when address too short');
        } catch (ValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'address' => $this->getRandomString(256)
            ]);
            self::fail('Did not throw exception when address too long');
        } catch (ValidationException $e) {
            self::assertEquals('Address invalid: must be between 2 and 255 characters long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'address' => '90 Whitehouse Way'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'postcode' => 'abc de'
            ]);
            self::fail('Did not throw exception when postcode too short');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'postcode' => 'abce fghi'
            ]);
            self::fail('Did not throw exception when postcode too short');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'postcode' => 'en26pj'
            ]);
            self::fail('Did not throw exception when postcode too short');
        } catch (ValidationException $e) {
            self::assertEquals('Postcode invalid: must include a space', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'joaquim',
                "address" => "203 Mawney Road",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'postcode' => 'en2 6pj'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'city' => 'a'
            ]);
            self::fail('Did not throw exception when city too short');
        } catch (ValidationException $e) {
            self::assertEquals('City invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'city' => $this->getRandomString(101)
            ]);
            self::fail('Did not throw exception when city too long');
        } catch (ValidationException $e) {
            self::assertEquals('City invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'city' => 'London'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'localArea' => 'a'
            ]);
            self::fail('Did not throw exception when localArea too short');
        } catch (ValidationException $e) {
            self::assertEquals('Local area invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'localArea' => $this->getRandomString(101)
            ]);
            self::fail('Did not throw exception when localArea too long');
        } catch (ValidationException $e) {
            self::assertEquals('Local area invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'localArea' => 'Brixton'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'landline' => '079hello46'
            ]);
            self::fail('Did not throw exception when landline not numeric');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: only numbers allowed', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'landline' => '12345678'
            ]);
            self::fail('Did not throw exception when landline too short');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'landline' => '123456789012345678901'
            ]);
            self::fail('Did not throw exception when landline too long');
        } catch (ValidationException $e) {
            self::assertEquals('Landline invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'landline' => '07700123123'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'mobile' => '079hello46'
            ]);
            self::fail('Did not throw exception when mobile not numeric');
        } catch (ValidationException $e) {
            self::assertEquals('Mobile invalid: only numbers allowed', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'mobile' => '12345678'
            ]);
            self::fail('Did not throw exception when mobile too short');
        } catch (ValidationException $e) {
            self::assertEquals('Mobile invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'mobile' => '123456789012345678901'
            ]);
            self::fail('Did not throw exception when mobile too long');
        } catch (ValidationException $e) {
            self::assertEquals('Mobile invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'mobile' => '07700123123'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'website' => 'o.re'
            ]);
            self::fail('Did not throw exception when website too short');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'website' => $this->getRandomString(101)
            ]);
            self::fail('Did not throw exception when website too long');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'website' => 'joaquimcom'
            ]);
            self::fail('Did not throw exception when website invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Website invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'website' => 'joaquim.com'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'email' => 'j@o.a'
            ]);
            self::fail('Did not throw exception when email too short');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: too short', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'email' => $this->getRandomString(101)
            ]);
            self::fail('Did not throw exception when email too long');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: too long', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'email' => 'joaquim@com'
            ]);
            self::fail('Did not throw exception when website invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'email' => 'joaquim.com'
            ]);
            self::fail('Did not throw exception when website invalid');
        } catch (ValidationException $e) {
            self::assertEquals('Email invalid: must include a domain', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'email' => 'joaquim@outlandish.com'
            ]);
        } catch (ValidationException $e) {
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
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'category' => 'a'
            ]);
            self::fail('Did not throw exception when category unknown');
        } catch (ValidationException $e) {
            self::assertEquals('Category invalid: unknown category', $e->getMessage());
        }

        try {
            $this->validator->validate([
                'name' => 'Link Computer Services',
                "address" => "203 Mawney Road",
                "postcode" => "RM7 8BX",
                "description" => "Laptop, PC, and Netbook repairs, mobile service.",
                'category' => 'Computers and Home Office'
            ]);
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
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