<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use Illuminate\Http\Request;
use League\Tactician\CommandBus;
use TheRestartProject\RepairDirectory\Domain\Models\FixometerSession;
use TheRestartProject\RepairDirectory\Domain\Repositories\FixometerSessionRepository;

/**
 * Fixometer Session Service that can be used to interact with the session table
 *
 * @category Auth
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class FixometerSessionService
{
    /**
     * The repository class for the FixometerSession
     *
     * @var FixometerSessionRepository
     */
    private $repository;

    /**
     * The command bus for running commands
     *
     * @var CommandBus
     */
    private $bus;

    /**
     * The request for interacting with the http
     *
     * @var null|Request
     */
    private $request;

    /**
     * Constructs the Fixometer Session Service
     *
     * @param FixometerSessionRepository $repository The session repository
     * @param CommandBus                 $bus        The command bus for the application
     * @param Request|null               $request    The http request
     */
    public function __construct(
        FixometerSessionRepository $repository,
        CommandBus $bus,
        Request $request = null
    ) {
        $this->repository = $repository;
        $this->bus = $bus;
        $this->request = $request;
    }

    /**
     * Gets the User Id from the Fixometer Session
     *
     * This method gets the session token from the user's cookies,
     * then finds the fixometer session for that token. If it
     * doesn't exist it returns null, otherwise it returns the user
     * id from the fixometer session.
     *
     * @return int|null
     */
    public function getUserId()
    {
        $sessionToken = $this->getSessionToken();

        $session = $this->repository->findOneBySession($sessionToken);

        if ($session === null) {
            return null;
        }

        return $session->getUser();
    }

    /**
     * Gets the session token from the cookie
     *
     * @return string
     */
    protected function getSessionToken()
    {
    }
}