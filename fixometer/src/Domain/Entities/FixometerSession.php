<?php

namespace TheRestartProject\Fixometer\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Entity to represent the Fixometer Session table
 *
 * @category Entity
 * @package  TheRestartProject\Fixometer\Domain\Entities
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class FixometerSession
{
    use HasFactory;

    /**
     * Unique id for the session
     *
     * @var int
     */
    private $idsessions;

    /**
     * The randomly generated string for the session
     *
     * @var string
     */
    private $session;

    /**
     * The id of the user associated with this session
     *
     * @var int
     */
    private $user;

    /**
     * The DateTime for when this session record was first created
     *
     * @var \DateTime
     */
    private $createdAt;

    /**
     * The DateTim for when this session record was last created
     *
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * Get the unique id for this session
     *
     * @return int
     */
    public function getIdsessions()
    {
        return $this->idsessions;
    }

    /**
     * Set the unique id for this session
     *
     * @param int $idsessions the unique id
     *
     * @return void
     */
    public function setIdsessions($idsessions)
    {
        $this->idsessions = $idsessions;
    }

    /**
     * Get the randomly generated string that represents this session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the randomly generated string that represents this session
     *
     * @param string $session the randomly generated string
     *
     * @return void
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get the id of the user associated with this session
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the id of the user associated with this session
     *
     * @param int $user the user id
     *
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get the time that the session was first created
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the time that the session was first created
     *
     * @param \DateTime $createdAt the datetime that the session was first created
     *
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the DateTime that the session was last modified
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set the DateTime that the session was last modified
     *
     * @param \DateTime $modifiedAt the datetime that the session was last modified
     *
     * @return void
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }
}