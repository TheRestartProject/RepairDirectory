<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

use Illuminate\Contracts\Auth\Authenticatable;

/**
 * The user who can be logged into the application
 *
 * @category Entity
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://laravel.com/docs/5.4/dusk
 */
class User implements Authenticatable
{
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
     * The remember token, or null if none is set
     *
     * @var null|string
     */
    private $remember;

    /**
     * Get the email address for the user
     *
     * @return string
     */
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
        return $this->remember;
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
        $this->remember = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember';
    }
}