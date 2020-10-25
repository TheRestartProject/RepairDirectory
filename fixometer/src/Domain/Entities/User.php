<?php

namespace TheRestartProject\Fixometer\Domain\Entities;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * The user who can be logged into the application
 *
 * @category Entity
 * @package  TheRestartProject\Fixometer\Domain\Entities
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class User implements Authenticatable
{
    /**
     * The role Ids
     */
    const ROOT = 1;
    const ADMINISTRATOR = 2;
    const HOST = 3;
    const RESTARTER = 4;
    const GUEST = 5;

    /**
     * Unique Id for the user
     *
     * @var integer
     */
    private $uid;

    /**
     * The unique email address the user
     *
     * @var string
     */
    private $email;

    /**
     * The hashed password for the user
     *
     * @var string
     */
    private $password;

    /**
     * The name of the user
     *
     * @var string
     */
    private $name;

    /**
     * The role for the user
     *
     * @var integer
     */
    private $role;

    /**
     * The remember token, or null if none is set
     *
     * @var string
     */
    private $recovery = '';

    /**
     * The the time when the recovery token expires
     *
     * @var \DateTime
     */
    private $recoveryExpires = '';

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
    private $modifiedAt = '';

    /**
     * Get the email address for the user
     *
     * @return string
     */


    private $repairDirectoryRole = null;
    public function getRepairDirectoryRole()
    {
        return $this->repairDirectoryRole;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email address for the user
     *
     * @param string $email The email address
     *
     * @return void;
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the hashed password for the user
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the hashed password for the user
     *
     * @param string $password The hashed password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Gets the id for the user
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets the id for the user
     *
     * @param int $uid the unique identifier for the user
     *
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Get the name of the user
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of this user
     *
     * @param string $name The name of the user
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the id of the role for this user
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the id of the role for this user
     *
     * @param int $role The role id
     *
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get the recovery token for the user
     *
     * @return string
     */
    public function getRecovery()
    {
        return $this->recovery;
    }

    /**
     * Set the recovery token for the user
     *
     * @param string $recovery The recovery token
     *
     * @return void
     */
    public function setRecovery($recovery)
    {
        $this->recovery = $recovery;
    }

    /**
     * Get the time that the recovery token should expire
     *
     * @return \DateTime
     */
    public function getRecoveryExpires()
    {
        return $this->recoveryExpires;
    }

    /**
     * Set the time that the recovery token should expire
     *
     * @param \DateTime $recoveryExpires The time that the recovery token expires
     *
     * @return void
     */
    public function setRecoveryExpires($recoveryExpires)
    {
        $this->recoveryExpires = $recoveryExpires;
    }

    /**
     * Get the time that the user was created
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the time that the user was created
     *
     * @param \DateTime $createdAt The time that the user was created
     *
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the time that the user was last modified
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set the time that the user was last modified
     *
     * @param \DateTime $modifiedAt The time that the user was last modified
     *
     * @return void
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'uid';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getUid();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->recovery;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value The remember token
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->recovery = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'recovery';
    }

    public function isSuperAdmin()
    {
        $role = $this->getRepairDirectoryRole();
        if (empty($role))
            return false;

        return $role->getName() == 'SuperAdmin';
    }
}
