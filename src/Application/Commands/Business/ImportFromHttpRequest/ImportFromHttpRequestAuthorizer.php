<?php

namespace TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest;
use Illuminate\Auth\AuthManager;
use TheRestartProject\RepairDirectory\Domain\Authorizers\ImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Domain\Repositories\BusinessRepository;


/**
 * Class ImportFromHttpRequestAuthorizer
 *
 * @category
 * @package  TheRestartProject\RepairDirectory\Application\Commands\Business\ImportFromHttpRequest
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class ImportFromHttpRequestAuthorizer
{
    /**
     * @var ImportBusinessAuthorizer
     */
    private $authorizer;

    /**
     * @var BusinessRepository
     */
    private $repository;

    public function __construct(
        ImportBusinessAuthorizer $authorizer,
        BusinessRepository $repository
    ) {
        $this->authorizer = $authorizer;
        $this->repository = $repository;
    }

    public function authorize(ImportFromHttpRequestCommand $command)
    {
        $uid = $command->getBusinessUid();
        if ($uid === null) {
            $business = null;
        } else {
            $business = $this->repository->findById($command->getBusinessUid());
        }

        $this->authorizer->authorize($command->getData(), $business);
    }
}