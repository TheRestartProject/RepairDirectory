<?php

namespace TheRestartProject\RepairDirectory\Domain\Services;

use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\Category;

class BusinessValidator {

    public function __construct () {
        $this->required = [
            'name',
            'address',
            'postcode',
            'description'
        ];
        $this->validators = [
            'name' => function ($name) {
                if (strlen($name) < 2 || strlen($name) > 255) {
                    throw new ValidationException(['Name invalid: must be between 2 and 255 characters long']);
                }
            },
            'description' => function ($description) {
                if (strlen($description) < 10 ) {
                    throw new ValidationException(['Description invalid: must be at least 10 characters long']);
                }
                if (strlen($description) > 65535) {
                    throw new ValidationException(['Description invalid: too long']);
                }
            },
            'address' => function ($address) {
                if (strlen($address) < 2 || strlen($address) > 255) {
                    throw new ValidationException(['Address invalid: must be between 2 and 255 characters long']);
                }
            },
            'postcode' => function ($postcode) {
                if (strpos($postcode, " ") === false) {
                    throw new ValidationException(['Postcode invalid: must include a space']);
                }
                if (strlen($postcode) < 7) {
                    throw new ValidationException(['Postcode invalid: too short']);
                }
                if (strlen($postcode) > 8) {
                    throw new ValidationException(['Postcode invalid: too long']);
                }
            },
            'city' => function ($city) {
                if (strlen($city) < 2) {
                    throw new ValidationException(['City invalid: too short']);
                }
                if(strlen($city) > 100) {
                    throw new ValidationException(['City invalid: too long']);
                }
            },
            'localArea' => function ($localArea) {
                if (strlen($localArea) < 2) {
                    throw new ValidationException(['Local area invalid: too short']);
                }
                if(strlen($localArea) > 100) {
                    throw new ValidationException(['Local area invalid: too long']);
                }
            },
            'landline' => function ($landline) {
                $chars = str_split($landline);
                foreach ($chars as $char) {
                    if ($char !== ' ' && !is_numeric($char)) {
                        throw new ValidationException(['Landline invalid: only numbers allowed']);
                    }
                }
                if(strlen($landline) < 10) {
                    throw new ValidationException(['Landline invalid: too short']);
                }
                if(strlen($landline) > 20) {
                    throw new ValidationException(['Landline invalid: too long']);
                }
            },
            'mobile' => function ($mobile) {
                $chars = str_split($mobile);
                foreach ($chars as $char) {
                    if ($char !== ' ' && !is_numeric($char)) {
                        throw new ValidationException(['Mobile invalid: only numbers allowed']);
                    }
                }
                if(strlen($mobile) < 10) {
                    throw new ValidationException(['Mobile invalid: too short']);
                }
                if(strlen($mobile) > 20) {
                    throw new ValidationException(['Mobile invalid: too long']);
                }
            },
            'website' => function ($website) {
                if(strlen($website) > 100) {
                    throw new ValidationException(['Website invalid: too long']);
                }
                if(strlen($website) < 5) {
                    throw new ValidationException(['Website invalid: too short']);
                }
                if(strpos($website, '.') === false) {
                    throw new ValidationException(['Website invalid: must include a domain']);
                }
            },
            'email' => function ($email) {
                if(strlen($email) > 100) {
                    throw new ValidationException(['Email invalid: too long']);
                }
                if(strlen($email) < 6) {
                    throw new ValidationException(['Email invalid: too short']);
                }
                if(strpos($email, "@") === false || strpos($email, '.') === false) {
                    throw new ValidationException(['Email invalid: must include a domain']);
                }
            },
            'category' => function ($category) {
                $foundCategory = Category::search($category);
                if (!$foundCategory) {
                    throw new ValidationException(['Category invalid: unknown category']);
                }
            }
        ];
    }

    public function validate($data)
    {
        $errors = [];

        foreach ($this->required as $field) {
            if (!array_key_exists($field, $data) || !$data[$field]) {
                $errors[$field] = $field . ' is required';
            }
        }

        foreach ($this->validators as $key => $validator) {
            if (array_key_exists($key, $data)) {
                $value = $data[$key];
                if ($value) {
                    try {
                        $validator($data[$key]);
                    } catch (ValidationException $e) {
                        $errors[$key] = $e->getMessage();
                    }
                }
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }

}
