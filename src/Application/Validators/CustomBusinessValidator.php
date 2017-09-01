<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;
use TheRestartProject\RepairDirectory\Validation\Validators as v;
use TheRestartProject\RepairDirectory\Validation\Validators\Validator;

/**
 * Class BusinessValidator.
 *
 * Validates instances of the Business class according to business logic. The validate function either
 * throws a BusinessValidationException or returns void.
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Validators
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @SuppressWarnings(PHPMD.Coupling\BetweenObjects)
 */
class CustomBusinessValidator implements BusinessValidator
{
    /**
     * An array of fields that cannot be missing or have a falsey value in the Business
     * E.G. [ 'name', 'address' ]
     *
     * @var array
     */
    private $required;

    /**
     * An array of Validators keyed by field name. If a field has an invalid value, the matching validator will throw
     * a ValidationException when its validate method is called with this value.
     *
     * @var array
     */
    private $validators;

    /**
     * BusinessValidator constructor.
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
            'name' => new v\StringLengthValidator('Name', 2, 255),
            'description' => new v\StringLengthValidator('Description', 10, 65535),
            'address' => new v\StringLengthValidator('Address', 2, 255),
            'postcode' => new v\StringLengthValidator('Postcode', 1, 64),
            'city' => new v\StringLengthValidator('City', 2, 100),
            'localArea' => new v\StringLengthValidator('Local Area', 2, 100),
            'landline' => new v\PhoneNumberValidator('Landline'),
            'mobile' => new v\PhoneNumberValidator('Mobile'),
            'website' => new v\WebsiteValidator(),
            'email' => new v\EmailValidator(),
            'categories' => new v\CategoriesValidator(),
            'qualifications' => new v\StringLengthValidator('Qualifications', 0, 255),
            'communityEndorsement' => new v\StringLengthValidator('Community Endorsement', 0, 255),
            'notes' => new v\StringLengthValidator('Notes', 0, 65535),
            'reviewSourceUrl' => new v\UrlValidator('Review Source URL'),
            'reviewSource' => new v\ReviewSourceValidator(),
            'positiveReviewPc' => new v\NumberRangeValidator('Positive Review Scores', 0, 100, false),
            'numberOfReviews' => new v\NumberRangeValidator('Number of Reviews', 0, 65535, false),
            'averageScore' => new v\NumberRangeValidator('Average Score', 0, 5, true),
            'warrantyOffered' => new v\BooleanValidator(),
            'warranty' => new v\StringLengthValidator('Warranty Details', 10, 65535),
            'publishingStatus' => new PublishingStatusValidator()
        ];
    }

    /**
     * Throw a BusinessValidationException if the provided business has any invalid fields.
     *
     * @param array $business The business to validate
     *
     * @return void
     *
     * @throws BusinessValidationException Thrown if the business is invalid
     */
    public function validate($business)
    {
        $errors = [];

        $this->ensureRequiredFields($business, $errors);

        // simple field validators
        $this->validateFields($business, $errors);

        if (count($errors)) {
            throw new BusinessValidationException($business, $errors);
        }
    }

    /**
     * Throw an error if the Business's publishing status is not allowed according to business logic.
     *
     * @param array $business The Business to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function validateBusinessPublishingStatus($business)
    {
        $messages = [];
        // PublishingStatus + PositiveReviewPc
        if ($business['publishingStatus'] === PublishingStatus::PUBLISHED && $business['positiveReviewPc'] < 80) {
            $messages[] = 'Can\'t publish a business with a positive review percentage of under 80%';
        }
        // PublishingStatus + WarrantyOffered
        if ($business['publishingStatus'] === PublishingStatus::PUBLISHED && !$business['warrantyOffered']) {
            $messages[] = 'Can\'t publish a business that doesn\'t offer warranty.';
        }

        if (count($messages)) {
            throw new ValidationException(implode(', ', $messages));
        }
    }

    /**
     * Ensures that all required fields exist and have a value
     *
     * @param array $business The business data to validate
     * @param array $errors   The errors array
     *
     * @return void
     */
    protected function ensureRequiredFields($business, &$errors)
    {
        foreach ($this->required as $field) {
            if (!array_key_exists($field, $business) || !$business[$field]) {
                $errors[$field] = $field . ' is required';
            }
        }
    }

    /**
     * Validates all fields in the data
     *
     * @param array $business The business data to validate
     * @param array $errors   The errors array
     *
     * @return void
     */
    protected function validateFields($business, &$errors)
    {
        foreach ($this->validators as $field => $validator) {
            $value = $business[$field];
            if ($value) {
                try {
                    /**
                     * The Validator for the current field
                     *
                     * @var Validator $validator
                     */
                    $validator->validate($value);
                } catch (ValidationException $e) {
                    $errors[$field] = $e->getMessage();
                }
            }
        }

        // Combined Validators
        try {
            $this->validateBusinessPublishingStatus($business);
        } catch (ValidationException $e) {
            $errors['publishingStatus'] = $e->getMessage();
        }


        if (!array_key_exists('geolocation', $business) || !$business['geolocation']) {
            $errors['geolocation'] = 'Geocoding failed – please check the address';
        }

    }

    public function validateField($field, $value)
    {
        if (in_array($field, $this->required) && !$value) {
            throw new ValidationException("$field is required");
        }
        
        if ($value && array_key_exists($field, $this->validators)) {
            $this->validators[$field]->validate($value);
        }
    }
}
