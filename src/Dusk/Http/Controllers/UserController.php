<?php

namespace TheRestartProject\RepairDirectory\Dusk\Http\Controllers;


use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Retrieve the authenticated user identifier and class name.
     *
     * @param  string|null  $guard
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
     * @param  string  $userId
     * @param  string  $guard
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
     * @param  string  $guard
     * @return Response
     */
    public function logout($guard = null)
    {
        Auth::guard($guard ?: config('auth.defaults.guard'))->logout();
    }

    /**
     * Get the model for the given guard.
     *
     * @param  string  $guard
     * @return string
     */
    protected function modelForGuard($guard)
    {
        $provider = config("auth.guards.{$guard}.provider");

        return config("auth.providers.{$provider}.model");
    }
}