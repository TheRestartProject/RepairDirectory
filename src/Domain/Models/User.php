<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 19/08/17
 * Time: 12:24
 */

namespace TheRestartProject\RepairDirectory\Domain\Models;


class User
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

}