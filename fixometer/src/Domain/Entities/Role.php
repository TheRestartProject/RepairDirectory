<?php

namespace TheRestartProject\Fixometer\Domain\Entities;

/**
 * The user who can be logged into the application
 *
 * @category Entity
 * @package  TheRestartProject\Fixometer\Domain\Entities
 * @author   Neil Mather <neil@therestartproject.org>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class Role
{
    const NONE = 0;
    const SUPERADMIN = 1;
    const REGIONAL_ADMIN = 2;
    const EDITOR = 3;

    /**
     * Unique Id for the role
     *
     * @var integer
     */
    private $uid;

    /**
     * The name of the role
     *
     * @var string
     */
    private $name;
    /**
     * The the time when the user was originally created
     *
     * @var \DateTime
     */
    private $createdAt = '';

    /**
     * The the time when the user was last modified
     *
     * @var \DateTime
     */
    private $updatedAt = '';

    /**
     * Gets the id for the role
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Get the name of the role
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
