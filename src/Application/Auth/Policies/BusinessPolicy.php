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
     * Checks that user can update the business.  This allows editing of the business, but not making the
     * business visible on the site, which is controlled by publish below.
     *
     * @param User     $user     The user to check
     * @param Business $business The business that is being updated
     *
     * @return bool
     */
    public function update(User $user, Business $business)
    {
        // If we have publish permission, which is higher, we can update.
        // Otherwise we can update if we are an editor and this business is not yet published.
        return $this->publish($user, $business) ||
            ($user->isEditor() &&
                ($business->getPublishingStatus() === PublishingStatus::DRAFT ||
                $business->getPublishingStatus() === PublishingStatus::READY_FOR_REVIEW ||
                $business->getPublishingStatus() === PublishingStatus::PUBLISHED));
    }

    /**
     * Checks that user can publish the business.  This is a higher permission than update above.
     *
     * @param User     $user     The user to check
     * @param Business $business The business that is being updated
     *
     * @return bool
     */
    public function publish(User $user, Business $business)
    {
        // SuperAdmins and RegionalAdmins can publish.
        return $user->isSuperAdmin() || $user->isRegionalAdmin();
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
