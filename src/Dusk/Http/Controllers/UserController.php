<?php

namespace TheRestartProject\RepairDirectory\Dusk\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Auth;

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
     * The entity manager
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Creates a new UserController
     *
     * @param EntityManagerInterface $entityManager The doctrine entity manager
     *
     * @return UserController
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        $user = Auth::guard($guard)->user();

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
     * @param string $userId The user id to login with
     * @param string $guard  The name of the guard or null
     *
     * @return Response
     */
    public function login($userId, $guard = null)
    {
        $model = $this->modelForGuard(
            $guard = $guard ?: config('auth.defaults.guard')
        );

        $user = $this->entityManager->getRepository($model)->find($userId);

        Auth::guard($guard)->login($user);
    }

    /**
     * Log the user out of the application.
     *
     * @param string $guard The name of the guard or null
     *
     * @return Response
     */
    public function logout($guard = null)
    {
        Auth::guard($guard ?: config('auth.defaults.guard'))->logout();
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
}