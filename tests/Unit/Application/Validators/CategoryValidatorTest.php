<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Application\Validators\CategoryValidator;
use TheRestartProject\RepairDirectory\Application\Validators\Validator;
use TheRestartProject\RepairDirectory\Tests\ValidationTestCase;

/**
 * Test class for the CategoryValidator class
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class CategoryValidatorTest extends ValidationTestCase
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
        $this->validator = new CategoryValidator();
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
            self::fail('Did not throw exception when category unknown');
        } catch (ValidationException $e) {
            self::assertEquals('Category invalid: unknown category', $e->getMessage());
        }

        try {
            $this->validator->validate('Computers and Home Office');
        } catch (ValidationException $e) {
            self::fail('Should not throw exception');
        }
    }

}