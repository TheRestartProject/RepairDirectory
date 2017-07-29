<?php

namespace TheRestartProject\RepairDirectory\Application\Business\Handlers;


use TheRestartProject\RepairDirectory\Application\Business\Commands\ImportBusinessFromCsvRowCommand;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;

class ImportBusinessFromCsvRowHandler
{
    /**
     * @var BusinessRepository
     */
    private $businessRepository;

    public function __construct(BusinessRepository $businessRepository)
    {
        $this->businessRepository = $businessRepository;
    }

    public function handle(ImportBusinessFromCsvRowCommand $command)
    {
        $business = BusinessFactory::fromCsvRow($command->getRow());
        $this->businessRepository->add($business);
    }
}