<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\DeleteBusiness;


use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use UnexpectedValueException;

/**
 * Handles the DeleteBusinessCommand to delete a Business
 *
 * @category CommandHandler
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromCsvRow
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://tactician.thephpleague.com/
 */
class DeleteBusinessHandler
{
    /**
     * An implementation of the BusinessRepository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * Creates the handler for the DeleteBusinessCommand
     *
     * @param BusinessRepository $repository An implementation of the BusinessRepository
     */
    public function __construct(BusinessRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles the Command by remove a business from the repository
     *
     * @param DeleteBusinessCommand $command The command to handle
     *
     * @return void
     */
    public function handle(DeleteBusinessCommand $command)
    {
        $business = $this->repository->findById($command->getUid());
        if ($business) {
            $this->repository->remove($business);
        }
    }
}
