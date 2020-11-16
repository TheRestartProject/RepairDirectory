<?php

namespace TheRestartProject\RepairDirectory\Application\Auth\Policies;

use TheRestartProject\RepairDirectory\Domain\Enums\PublishingStatus;
use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\Fixometer\Domain\Entities\User;

/**
 * Determines whether a user to perform actions on a Business
 *
 * @category Policy
 * @package  TheRestartProject\RepairDirectory\Application\Auth\Policies
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
class BusinessPolicy
{
    /**
     * Runs before any policy action
     *
     * @param User $user The user to check
     *
     * @return bool|void
     */
    public function before(User $user)
    {
        if ($this->userIsSuperAdmin($user)) {
            return true;
        }
    }


    /**
     * Checks whether a user can create a business
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    public function create(User $user)
    {
        return !$this->userIsGuest($user);
    }

    /**
     * Checks whether a user can list the businesses
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    public function index(User $user)
    {
        return !$this->userIsGuest($user);
    }

    /**
     * Checks that user can update the business
     *
     * @param User     $user     The user to check
     * @param Business $business The business that is being updated
     *
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        // SuperAdmins, RegionalAdmins and Editors can update.
        return $user->isSuperAdmin() || $user->isRegionalAdmin() || $user->isEditor();
    }

    /**
     * Checks that user can view the business
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    public function view(User $user)
    {
        return !$this->userIsGuest($user);
    }

    /**
     * Checks whether the user is an admin
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    protected function userIsSuperAdmin(User $user)
    {
        return $user->isSuperAdmin();
    }

    /**
     * Checks whether the user is a guest
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    protected function userIsGuest(User $user)
    {
        return $user->getRole() === 5;
    }

    /**
     * Checks whether the user is a Restarter
     *
     * @param User $user The user to check
     *
     * @return bool
     */
    protected function userIsRestarter(User $user)
    {
        return $user->getRole() === 4;
    }
}
