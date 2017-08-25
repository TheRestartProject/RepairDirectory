<?php

namespace TheRestartProject\RepairDirectory\Application\Auth\Policies;

use TheRestartProject\RepairDirectory\Domain\Models\Business;
use TheRestartProject\Fixometer\Domain\Entities\User;

/**
 * Class BusinessPolicy
 * @category
 * @package  TheRestartProject\RepairDirectory\Application\Auth\Policies
 * @author   Matthew Kendon <matt@outlandish.com>
 */
class BusinessPolicy
{
    /**
     * Runs before any policy action
     *
     * @param User $user
     *
     * @return bool|void
     */
    public function before(User $user)
    {
        if ($this->userIsAdmin($user)) {
            return true;
        }
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
        if ($this->userIsGuest($user)) {
            return false;
        }

        return $this->userIsRestarter($user) && !$business->isPublished();
    }

    /**
     * Checks whether the user is an admin
     *
     * @param User $user
     *
     * @return bool
     */
    protected function userIsAdmin(User $user)
    {
        return in_array($user->getRole(), [1, 2, 3], true);
    }

    /**
     * Checks whether the user is a guest
     *
     * @param User $user
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
     * @param User $user
     *
     * @return bool
     */
    protected function userIsRestarter(User $user)
    {
        return $user->getRole() === 4;
    }
}