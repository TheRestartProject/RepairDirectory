<?php

namespace TheRestartProject\RepairDirectory\Application\Business\Handlers;


use TheRestartProject\RepairDirectory\Application\Business\Commands\
ImportFromCsvRowCommand;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use TheRestartProject\RepairDirectory\Infrastructure\ModelFactories\BusinessFactory;

/**
 * Handles the ImportFromCsvRowCommand to import a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Business\Handlers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class ImportFromCsvRowHandler
{
    /**
     * An implementation of the BusinessRepository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * The factory to create the business with
     *
     * @var BusinessFactory
     */
    private $factory;

    /**
     * Creates the handler for the ImportBusinessFromCsvRowCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     * @param BusinessFactory    $factory    Factory class to construct businesses
     */
    public function __construct(BusinessRepository $repository, BusinessFactory $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Handles the Command by importing a Business from a CSV row
     *
     * @param ImportFromCsvRowCommand $command The command to handle
     *
     * @return Business
     */
    public function handle(ImportFromCsvRowCommand $command)
    {
        $business = $this->factory->fromCsvRow($command->getRow());
        $this->repository->add($business);

        return $business;
    }
}
