<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

use TheRestartProject\RepairDirectory\Application\Exceptions\BusinessValidationException;
use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;

/**
 * Validates the ImportFromHttpRequestCommand
 *
 * @category Validator
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromHttpRequestValidator
{
    /**
     * Validator to run for the command
     *
     * @var CustomBusinessValidator
     */
    private $businessValidator;

    /**
     * Constructs the validator for a command
     *
     * @param BusinessValidator $businessValidator The validator to be run for the command
     *
     * @return self
     */
    public function __construct(BusinessValidator $businessValidator)
    {
        $this->businessValidator = $businessValidator;
    }

    /**
     * Validates the command
     *
     * @param ImportFromHttpRequestCommand $command The command to validate
     *
     * @return void
     *
     * @throws BusinessValidationException
     */
    public function validate(ImportFromHttpRequestCommand $command)
    {
        $data = $command->getData();
        $this->businessValidator->validate($data);
    }
}