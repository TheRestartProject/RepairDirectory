<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Class BusinessValidator
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Domain\Services
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class BusinessValidator
{
    /**
     * An array of field names that cannot be missing or have a falsey value
     *
     * @var array
     */
    private $required;

    /**
     * An array of validation functions keyed by field name. The functions throw ValidationExceptions.
     *
     * @var array
     */
    private $validators;

    /**
     * BusinessValidator constructor.
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct()
    {
        $this->required = [
            'name',
            'address',
            'postcode',
            'description'
        ];
        $this->validators = [
            'name' => function ($name) {
                if (strlen($name) < 2 || strlen($name) > 255) {
                    throw new ValidationException('Name invalid: must be between 2 and 255 characters long');
                }
            },
            'description' => function ($description) {
                if (strlen($description) < 10) {
                    throw new ValidationException('Description invalid: must be at least 10 characters long');
                }
                if (strlen($description) > 65535) {
                    throw new ValidationException('Description invalid: too long');
                }
            },
            'address' => function ($address) {
                if (strlen($address) < 2 || strlen($address) > 255) {
                    throw new ValidationException('Address invalid: must be between 2 and 255 characters long');
                }
            },
            'postcode' => function ($postcode) {
                if (strpos($postcode, " ") === false) {
                    throw new ValidationException('Postcode invalid: must include a space');
                }
                if (strlen($postcode) < 7) {
                    throw new ValidationException('Postcode invalid: too short');
                }
                if (strlen($postcode) > 8) {
                    throw new ValidationException('Postcode invalid: too long');
                }
            },
            'city' => function ($city) {
                if (strlen($city) < 2) {
                    throw new ValidationException('City invalid: too short');
                }
                if (strlen($city) > 100) {
                    throw new ValidationException('City invalid: too long');
                }
            },
            'localArea' => function ($localArea) {
                if (strlen($localArea) < 2) {
                    throw new ValidationException('Local area invalid: too short');
                }
                if (strlen($localArea) > 100) {
                    throw new ValidationException('Local area invalid: too long');
                }
            },
            'landline' => function ($landline) {
                $chars = str_split($landline);
                foreach ($chars as $char) {
                    if ($char !== ' ' && !is_numeric($char)) {
                        throw new ValidationException('Landline invalid: only numbers allowed');
                    }
                }
                if (strlen($landline) < 10) {
                    throw new ValidationException('Landline invalid: too short');
                }
                if (strlen($landline) > 20) {
                    throw new ValidationException('Landline invalid: too long');
                }
            },
            'mobile' => function ($mobile) {
                $chars = str_split($mobile);
                foreach ($chars as $char) {
                    if ($char !== ' ' && !is_numeric($char)) {
                        throw new ValidationException('Mobile invalid: only numbers allowed');
                    }
                }
                if (strlen($mobile) < 10) {
                    throw new ValidationException('Mobile invalid: too short');
                }
                if (strlen($mobile) > 20) {
                    throw new ValidationException('Mobile invalid: too long');
                }
            },
            'website' => function ($website) {
                if (strlen($website) > 100) {
                    throw new ValidationException('Website invalid: too long');
                }
                if (strlen($website) < 5) {
                    throw new ValidationException('Website invalid: too short');
                }
                if (strpos($website, '.') === false) {
                    throw new ValidationException('Website invalid: must include a domain');
                }
            },
            'email' => function ($email) {
                if (strlen($email) > 100) {
                    throw new ValidationException('Email invalid: too long');
                }
                if (strlen($email) < 6) {
                    throw new ValidationException('Email invalid: too short');
                }
                if (strpos($email, "@") === false || strpos($email, '.') === false) {
                    throw new ValidationException('Email invalid: must include a domain');
                }
            },
            'category' => function ($category) {
                $foundCategory = Category::search($category);
                if (!$foundCategory) {
                    throw new ValidationException('Category invalid: unknown category');
                }
            }
        ];
    }

    /**
     * Throw a BusinessValidationException if the provided business has any invalid fields.
     *
     * @param Business $business The business to validate
     *
     * @return void
     *
     * @throws BusinessValidationException Thrown if the business is invalid
     */
    public function validate(Business $business)
    {
        $errors = [];
        $businessArr = $business->toArray();

        foreach ($this->required as $field) {
            if (!array_key_exists($field, $businessArr) || !$businessArr[$field]) {
                $errors[$field] = $field . ' is required';
            }
        }

        foreach ($this->validators as $field => $validator) {
            if (array_key_exists($field, $businessArr)) {
                $value = $businessArr[$field];
                if ($value) {
                    try {
                        $validator($businessArr[$field]);
                    } catch (ValidationException $e) {
                        $errors[$field] = $e->getMessage();
                    }
                }
            }
        }

        if (count($errors)) {
            throw new BusinessValidationException($business, $errors);
        }
    }

}
