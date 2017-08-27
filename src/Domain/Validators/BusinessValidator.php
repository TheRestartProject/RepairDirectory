<?php

namespace TheRestartProject\RepairDirectory\Domain\Validators;


use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

interface BusinessValidator
{

    /**
     * Throw a BusinessValidationException if the provided business has any invalid fields.
     *
     * @param Business $business The business to validate
     *
     * @return void
     *
     * @throws BusinessValidationException Thrown if the business is invalid
     */
    public function validate($business);
}