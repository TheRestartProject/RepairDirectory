<?php

namespace TheRestartProject\RepairDirectory\Domain\Authorizers;

use TheRestartProject\RepairDirectory\Domain\Models\Business;

/**
 * Run when a business is imported
 *
 * @category Authorizer
 * @package  TheRestartProject\RepairDirectory\Domain\
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     http://outlandish.com
 */
interface ImportBusinessAuthorizer
{
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
     * @param array    $data     The data that is to be inserted
     * @param Business $business The business that is to be updated or null if new
     *
     * @return void
     *
     * @throws ImportBusinessUnauthorizedException
     */
    public function authorize(array $data, Business $business = null);
}
