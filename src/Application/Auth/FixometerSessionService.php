<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use Illuminate\Contracts\Session\Session;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use League\Tactician\CommandBus;
use TheRestartProject\Fixometer\Domain\Entities\FixometerSession;
use TheRestartProject\Fixometer\Domain\Repositories\FixometerSessionRepository;

/**
 * Fixometer Session Service that can be used to interact with the session table
 *
 * @category Auth
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @SuppressWarnings(PHPMD)
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
     * The request object
     *
     * @var Request|null
     */
    private $request;

    /**
     * The CommandBus object
     *
     * @var CommandBus
     */
    private $bus;

    /**
     * FixometerSession Repository
     *
     * @var FixometerSessionRepository
     */
    private $repository;

    /**
     * The cookie jar for dealing with cookies
     *
     * @var CookieJar
     */
    private $cookieJar;

    /**
     * Constructs the Fixometer Session Service
     *
     * @param string                     $name       The name of the session
     * @param CommandBus                 $bus        The command bus for executing commands
     * @param FixometerSessionRepository $repository The repository for fixometer sessions
     * @param CookieJar                  $cookieJar  The cookie jar
     * @param Request|null               $request    The request object or null
     */
    public function __construct(
        $name,
        CommandBus $bus,
        FixometerSessionRepository $repository,
        CookieJar $cookieJar,
        Request $request = null
    ) {
        $this->name = $name;
        $this->request = $request;
        $this->bus = $bus;
        $this->repository = $repository;
        $this->cookieJar = $cookieJar;
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
     * Set the name of the session.
     *
     * @param $name
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get the current session ID.
     *
     * @return string
     */
    public function getId()
    {
        if (isset($_SESSION[APPNAME]) && isset($_SESSION[APPNAME][SESSIONKEY])) {
            return $_SESSION[APPNAME][SESSIONKEY];
        }

        return '';
    }

    /**
     * Set the session ID.
     *
     * @param string $id The token of the session
     *
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
     * @param string|array $key The key to that might exist
     *
     * @return bool
     */
    public function exists($key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * Checks if an a key is present and not null.
     *
     * @param string|array $key The key that might exist
     *
     * @return bool
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    public function pull($key, $default = null)
    {
        // TODO: Implement pull() method.
    }

    /**
     * Get an item from the session.
     *
     * @param string $key     The key to get from the session
     * @param mixed  $default The default value if none exists
     *
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
     * @param string|array $key   The key
     * @param mixed        $value The value
     *
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
            $_SESSION[APPNAME][SESSIONKEY] = $token;
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

    public function regenerateToken() {
        // TODO regenerate CSRF
    }

    public function regenerate($destroy = false) {
        if ($destroy) {
            session_destroy();
            session_start();
        }

        $_SESSION[APPNAME][SESSIONKEY] = Str::random(45);
    }

    public function invalidate() {
        // TODO invalidate session
    }

    /**
     * Remove an item from the session, returning its value.
     *
     * @param string $key The key to remove
     *
     * @return mixed
     */
    public function remove($key)
    {
        if ($key !== 'user') {
            return null;
        }

        $token = $this->getId();

        if (empty($token)) {
            return null;
        }

        //seeing as the user id is the only thing on the
        //fixometer session, removing it will also destroy
        //the session

        /**
         * The FixometerSession from the database
         *
         * @var \TheRestartProject\Fixometer\Domain\Entities\FixometerSession $session
         */
        $session = $this->repository->findOneBySession($token);

        $command = new DeleteFixometerSessionCommand($session->getIdsessions());

        $this->bus->handle($command);

        $this->cookieJar->forget($this->getName());

        unset($_SESSION[APPNAME]);

        return $session->getUser();
    }

    /**
     * Remove one or many items from the session.
     *
     * @param string|array $keys The keys to remove
     *
     * @return void
     */
    public function forget($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                $this->remove($key);
            }

            return;
        }

        $this->remove($keys);
    }

    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush()
    {
        $this->remove('user');
    }

    /**
     * Generate a new session ID for the session.
     *
     * @param bool $destroy Whether to destroy the session first
     *
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
        return true;
    }

    /**
     * Get the previous URL from the session.
     *
     * @return string|null
     */
    public function previousUrl()
    {
        return null;
    }

    /**
     * Set the "previous" URL in the session.
     *
     * @param string $url The url to set
     *
     * @return void
     */
    public function setPreviousUrl($url)
    {
        //do nothing
    }

    /**
     * Get the session handler instance.
     *
     * @return \SessionHandlerInterface
     */
    public function getHandler()
    {
        return new \SessionHandler();
    }

    /**
     * Determine if the session handler needs a request.
     *
     * @return bool
     */
    public function handlerNeedsRequest()
    {
        return false;
    }

    /**
     * Set the request on the handler instance.
     *
     * @param \Illuminate\Http\Request $request The request object
     *
     * @return void
     */
    public function setRequestOnHandler($request)
    {
        $this->request = $request;
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
