<?php

namespace TheRestartProject\RepairDirectory\Application\Authorizers;

use Illuminate\Auth\AuthManager;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException;
use TheRestartProject\RepairDirectory\Domain\Authorizers\ImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Class LaravelImportBusinessAuthorizer
 *
 * @category Authorizer
 * @package  TheRestartProject\RepairDirectory\Application\Authorizers
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class LaravelImportBusinessAuthorizer implements ImportBusinessAuthorizer
{
    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * LaravelImportBusinessAuthorizer constructor.
     *
     * @param AuthManager $authManager The authentication manager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Checks whether the business can be
     *
     * When importing a business, some rules are in place. For example
     * in the web app, a user must be logged in and must be of a certain
     * role to create a business.
     *
     * Additionally, a business cannot be published unless the user that is
     * logged in is of a specific role.
     *
     * @param array $data The data that is to be inserted
     * @param Business $business The business that is to be updated or null if new
     *
     * @return void
     *
     * @throws \TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException
     */
    public function authorize(array $data, Business $business = null)
    {
        $user = $this->getUser();

        if ($this->isUserLoggedIn($user)) {
            throw new ImportBusinessUnauthorizedException('User not logged in');
        }

        if ($this->isUserGuest($user)) {
            throw new ImportBusinessUnauthorizedException('User is a guest.');
        }
    }

    /**
     * Get the User if logged in or null
     *
     * @return User|null
     */
    protected function getUser()
    {
        /**
         * @var User $user The user that is currently authenticated
         */
        $user = $this->authManager->guard()->user();

        return $user;
    }

    /**
     * Checks whether the user is a guest
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    protected function isUserGuest($user)
    {
        return $user->getRole() === User::GUEST;
    }

    /**
     * Checks whether the user is logged in
     *
     * @param User|null $user The user to check against
     *
     * @return bool
     */
    protected function isUserLoggedIn($user)
    {
        return $user === null;
    }
}