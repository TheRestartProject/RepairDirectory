<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;

use TheRestartProject\RepairDirectory\Application\Exceptions\EntityNotFoundException;
use TheRestartProject\RepairDirectory\Domain\Authorizers\ImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class ImportFromHttpRequestAuthorizer
 *
 * @category Authorizer
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class ImportFromHttpRequestAuthorizer
{
    /**
     * The authorizer to run
     *
     * @var ImportBusinessAuthorizer
     */
    private $authorizer;

    /**
     * The business repository
     *
     * @var BusinessRepository
     */
    private $repository;

    /**
     * Constructs the Authorizer
     *
     * @param ImportBusinessAuthorizer $authorizer The authorizer to run for this command
     * @param BusinessRepository       $repository The business repository
     */
    public function __construct(
        ImportBusinessAuthorizer $authorizer,
        BusinessRepository $repository
    ) {
        $this->authorizer = $authorizer;
        $this->repository = $repository;
    }

    /**
     * Authorizes the command
     *
     * Either throws an exception or returns void
     *
     * @param ImportFromHttpRequestCommand $command The command to authorize
     *
     * @return void
     */
    public function authorize(ImportFromHttpRequestCommand $command)
    {
        $uid = $command->getBusinessUid();
        $business = null;
        if ($uid !== null) {
            $business = $this->repository->findById($uid, Auth::user());

            if (!$business) {
                throw new EntityNotFoundException("Business with id of {$uid} could not be found");
            }
        }

        $this->authorizer->authorize($command->getData(), $business);
    }
}
