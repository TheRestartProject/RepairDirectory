<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
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
class FixometerSessionService implements Session
{
    /**
     * The name of the session
     *
     * @var string
     */
    private $name;
    /**
     * @var Request|null
     */
    private $request;
    /**
     * @var CommandBus
     */
    private $bus;
    /**
     * @var FixometerSessionRepository
     */
    private $repository;

    /**
     * Constructs the Fixometer Session Service
     *
     * @param string                     $name The name of the session
     * @param CommandBus                 $bus The command bus for executing commands
     * @param FixometerSessionRepository $repository
     * @param Request|null               $request The request object or null
     */
    public function __construct(
        $name,
        CommandBus $bus,
        FixometerSessionRepository $repository,
        Request $request = null
    ) {
        $this->name = $name;
        $this->request = $request;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    /**
     * Get the name of the session.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the current session ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->getRequest()->cookie($this->getName(), '');
    }

    /**
     * Set the session ID.
     *
     * @param  string $id
     * @return void
     */
    public function setId($id)
    {
        // TODO: Implement setId() method.
    }

    /**
     * Start the session, reading the data from a handler.
     *
     * @return bool
     */
    public function start()
    {
        return false;
    }

    /**
     * Save the session data to storage.
     *
     * @return bool
     */
    public function save()
    {
        return false;
    }

    /**
     * Get all of the session data.
     *
     * @return array
     */
    public function all()
    {
        return [];
    }

    /**
     * Checks if a key exists.
     *
     * @param  string|array $key
     * @return bool
     */
    public function exists($key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * Checks if an a key is present and not null.
     *
     * @param  string|array $key
     * @return bool
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Get an item from the session.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($key !== 'user') {
            return $default;
        }

        $token = $this->getId();

        $session = $this->repository->findOneBySession($token);

        if ($session === null) {
            return $default;
        }

        return $session->getUser();
    }

    /**
     * Put a key / value pair or array of key / value pairs in the session.
     *
     * @param  string|array $key
     * @param  mixed $value
     * @return void
     */
    public function put($key, $value = null)
    {

        if ($key !== 'user') {
            return;
        }

        $tokenIsNew = false;
        $token = $this->getId();

        if (empty($token)) {
            $tokenIsNew = true;
            $token = Str::random(45);
        }

        $command = new UpdateFixometerSessionCommand($token, $value);

        try {
            $this->bus->handle($command);
        } catch (\Exception $e) {
            return;
        }

        if ($tokenIsNew) {
            Cookie::queue(
                Cookie::make(
                    $this->getName(),
                    $token,
                    3600,
                    null,
                    null
                )
            );

//            dd(Cookie::getQueuedCookies());
        }

    }

    /**
     * Get the CSRF token value.
     *
     * @return string
     */
    public function token()
    {
        return '';
    }

    /**
     * Remove an item from the session, returning its value.
     *
     * @param  string $key
     * @return mixed
     */
    public function remove($key)
    {
        if ($key !== 'user') {
            return null;
        }

        $token = $this->getId();

        if (emtpy($token)) {
            return null;
        }

        //seeing as the user id is the only thing on the
        //fixometer session, removing it will also destroy
        //the session

        /**
         * @var FixometerSession $session
         */
        $session = $this->repository->findByToken($token);

        $command = new DeleteFixometerSessionCommand($session->getUid());

        $this->bus->handle($command);

        return $session->getUser();
    }

    /**
     * Remove one or many items from the session.
     *
     * @param  string|array $keys
     * @return void
     */
    public function forget($keys)
    {
        // TODO: Implement forget() method.
    }

    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Generate a new session ID for the session.
     *
     * @param  bool $destroy
     * @return bool
     */
    public function migrate($destroy = false)
    {
        // TODO: Implement migrate() method.
    }

    /**
     * Determine if the session has been started.
     *
     * @return bool
     */
    public function isStarted()
    {
        // TODO: Implement isStarted() method.
    }

    /**
     * Get the previous URL from the session.
     *
     * @return string|null
     */
    public function previousUrl()
    {
        // TODO: Implement previousUrl() method.
    }

    /**
     * Set the "previous" URL in the session.
     *
     * @param  string $url
     * @return void
     */
    public function setPreviousUrl($url)
    {
        // TODO: Implement setPreviousUrl() method.
    }

    /**
     * Get the session handler instance.
     *
     * @return \SessionHandlerInterface
     */
    public function getHandler()
    {
        // TODO: Implement getHandler() method.
    }

    /**
     * Determine if the session handler needs a request.
     *
     * @return bool
     */
    public function handlerNeedsRequest()
    {
        // TODO: Implement handlerNeedsRequest() method.
    }

    /**
     * Set the request on the handler instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function setRequestOnHandler($request)
    {
        // TODO: Implement setRequestOnHandler() method.
    }

    /**
     * This returns the request
     *
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request ?: Request::createFromGlobals();
    }
}