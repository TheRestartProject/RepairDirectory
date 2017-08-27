<?php

namespace TheRestartProject\RepairDirectory\Application\Validators;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Application\Exceptions\ValidationException;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;
use TheRestartProject\RepairDirectory\Validation\Validators as v;

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
            'communityEndorsement' => new v\StringLengthValidator('Community Endorsement', 0, 100),
            'notes' => new v\StringLengthValidator('Notes', 0, 65535),
            'reviewSource' => new v\ReviewSourceValidator(),
            'positiveReviewPc' => new v\NumberRangeValidator('Positive Review Scores', 0, 100, false),
            'numberOfReviews' => new v\NumberRangeValidator('Number of Reviews', 0, 65535, false),
            'averageScore' => new v\NumberRangeValidator('Average Score', 0, 5, true),
            'warrantyOffered' => new v\BooleanValidator(),
            'warranty' => new v\StringLengthValidator('Warranty Details', 10, 65535),
            'publishingStatus' => new v\PublishingStatusValidator()
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
    public function validate($business)
    {
        $errors = [];
        $businessArr = $business->toArray();

        foreach ($this->required as $field) {
            if (!array_key_exists($field, $businessArr) || !$businessArr[$field]) {
                $errors[$field] = $field . ' is required';
            }
        }

        // simple field validators
        foreach ($this->validators as $field => $validator) {
            $value = $businessArr[$field];
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
        
        if (!$business->getGeolocation()) {
            $errors['geolocation'] = 'Geocoding failed – please check the address';
        }

        // Combined Validators
        try {
            $this->validateBusinessPublishingStatus($business);
        } catch (ValidationException $e) {
            $errors['publishingStatus'] = $e->getMessage();
        }

        if (count($errors)) {
            throw new BusinessValidationException($business, $errors);
        }
    }

    /**
     * Throw an error if the Business's publishing status is not allowed according to business logic.
     *
     * @param Business $business The Business to validate
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function validateBusinessPublishingStatus(Business $business)
    {
        $messages = [];
        // PublishingStatus + PositiveReviewPc
        if ($business->getPublishingStatus() === PublishingStatus::PUBLISHED && $business->getPositiveReviewPc() < 80) {
            $messages[] = 'Can\'t publish a business with a positive review percentage of under 80%';
        }
        // PublishingStatus + WarrantyOffered
        if ($business->getPublishingStatus() === PublishingStatus::PUBLISHED && !$business->isWarrantyOffered()) {
            $messages[] = 'Can\'t publish a business that doesn\'t offer warranty.';
        }

        if (count($messages)) {
            throw new ValidationException(implode(', ', $messages));
        }
    }

}
