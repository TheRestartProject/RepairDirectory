<?php

namespace TheRestartProject\RepairDirectory\Dusk\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use TheRestartProject\Fixometer\Domain\Repositories\UserRepository;

/**
 * User Controller for when using Dusk and needing to login a user
 *
 * @category Controller
 * @package  TheRestartProject\RepairDirectory\Dusk\Http\Controllers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class UserController
{
    /**
     * The user repository
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * Creates a new UserController
     *
     * @param \TheRestartProject\Fixometer\Domain\Repositories\UserRepository $repository The user repository
     *
     * @return UserController
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Retrieve the authenticated user identifier and class name.
     *
     * @param string|null $guard The name of the guard or null if default
     *
     * @return array
     */
    public function user($guard = null)
    {
        $user = $this->guard($guard)->user();

        if (! $user) {
            return [];
        }

        return [
            'id' => $user->getAuthIdentifier(),
            'className' => get_class($user),
        ];
    }

    /**
     * Login using the given user ID / email.
     *
     * @param int    $userId The user id to login with
     * @param string $guard  The name of the guard or null
     *
     * @return void
     */
    public function login($userId, $guard = null)
    {
        /**
         * The Authenticable User
         *
         * @var Authenticatable $user
         */
        $user = $this->repository->find($userId);

        $this->guard($guard)->login($user);
    }

    /**
     * Log the user out of the application.
     *
     * @param string $guard The name of the guard or null
     *
     * @return void
     */
    public function logout($guard = null)
    {
        $this->guard($guard)->logout();
    }

    /**
     * Get the model for the given guard.
     *
     * @param string $guard The name of the guard or null
     *
     * @return string
     */
    protected function modelForGuard($guard)
    {
        $provider = config("auth.guards.{$guard}.provider");

        return config("auth.providers.{$provider}.model");
    }

    /**
     * Returns the specified guard or default if no guard specified
     *
     * @param null|string $guard The name of the guard to get
     *
     * @return StatefulGuard
     */
    protected function guard($guard = null)
    {
        return auth()->guard($guard ?: config('auth.defaults.guard'));
    }
}
