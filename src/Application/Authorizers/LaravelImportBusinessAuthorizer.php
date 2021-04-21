<?php

namespace TheRestartProject\RepairDirectory\Application\Authorizers;

use Illuminate\Auth\AuthManager;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException;
use TheRestartProject\RepairDirectory\Domain\Authorizers\ImportBusinessAuthorizer;
use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Implementation of the Business Authorizer that uses Laravel services
 *
 * @category Authorizer
 * @package  TheRestartProject\RepairDirectory\Application\Authorizers
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class LaravelImportBusinessAuthorizer implements ImportBusinessAuthorizer
{
    /**
     * The Laravel auth manager
     *
     * @var AuthManager
     */
    private $authManager;

    /**
     * Constructs the ImportBusinessAuthorizer
     *
     * @param AuthManager $authManager The authentication manager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Checks whether the business is authorized to be imported
     *
     * When importing a business, some rules are in place. For example
     * in the web app, a user must be logged in and must be of a certain
     * role to create a business.
     *
     * Additionally, a business cannot be published unless the user that is
     * logged in is of a specific role.
     *
     * @param array    $data     The data that is to be inserted
     * @param Business $business The business that is to be updated or null if new
     *
     * @return void
     *
     * @throws \TheRestartProject\RepairDirectory\Domain\Exceptions\ImportBusinessUnauthorizedException
     */
    public function authorize(array $data, Business $business = null)
    {
        /**
         * Logged in user
         *
         * @var User $user
         */
        $user = $this->getUser();

        if ($this->isUserLoggedOut($user)) {
            throw new ImportBusinessUnauthorizedException('User not logged in');
        }

        if ($this->isUserGuest($user)) {
            throw new ImportBusinessUnauthorizedException('User is a guest.');
        }

        // Normal restarters can't edit.
        $editallowed = $user->isEditor() || $user->isRegionalAdmin() || $user->isSuperAdmin();

        if (!$editallowed) {
            if ($this->isUserRestarter($user) && $this->dataIsPublished($data)) {
                throw new ImportBusinessUnauthorizedException('User is a restarter and cannot publish businesses');
            }

            if ($this->isUserRestarter($user) && $this->businessIsPublished($business)) {
                throw new ImportBusinessUnauthorizedException('User is a restarter and cannot update a published business');
            }
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
         * The user that is currently authenticated
         *
         * @var User $user
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
    protected function isUserLoggedOut($user)
    {
        return $user === null;
    }

    /**
     * Checks that a user is a restarter or not
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    protected function isUserRestarter($user)
    {
        return $user->getRole() === User::RESTARTER;
    }

    /**
     * Returns true if the data includes the published status
     *
     * @param array $data The data to check
     *
     * @return bool
     */
    protected function dataIsPublished($data)
    {
        $statuses = [
            PublishingStatus::PUBLISHED,
            PublishingStatus::HIDDEN
        ];
        return in_array($data['publishingStatus'], $statuses, true);
    }

    /**
     * Checks that a business is published
     *
     * @param Business $business The business to check
     *
     * @return bool
     */
    protected function businessIsPublished(Business $business = null)
    {
        return $business !== null && $business->isPublished();
    }

}
