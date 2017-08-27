<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

use TheRestartProject\RepairDirectory\Domain\Validators\BusinessValidator;

/**
 * Class ImportFromHttpRequestValidator
 * @category
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ImportFromHttpRequestValidator
{
    /**
     * @var CustomBusinessValidator
     */
    private $businessValidator;

    public function __construct(BusinessValidator $businessValidator)
    {
        $this->businessValidator = $businessValidator;
    }

    public function validate(ImportFromHttpRequestCommand $command)
    {
        $data = $command->getData();

        $this->businessValidator->validate($data);
    }
}