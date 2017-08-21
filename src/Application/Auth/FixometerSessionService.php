<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 21/08/17
 * Time: 17:32
 */

namespace TheRestartProject\RepairDirectory\Application\Auth;


use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;

class FixometerSessionService
{
    /**
     * @var FixometerSessionRepository
     */
    private $repository;
    /**
     * @var CommandBus
     */
    private $bus;
    /**
     * @var null|Request
     */
    private $request;

    /**
     * Constructs the Fixometer Session Service
     *
     * @param FixometerSessionRepository $repository
     * @param CommandBus $bus
     * @param Request|null $request
     */
    public function __construct(
        FixometerSessionRepository $repository,
        CommandBus $bus,
        Request $request = null
    )
    {
        $this->repository = $repository;
        $this->bus = $bus;
        $this->request = $request;
    }

    public function getUserId()
    {

    }
}