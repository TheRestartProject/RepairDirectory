<?php

namespace TheRestartProject\RepairDirectory\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Suggestion
 *
 * @category Model
 * @package  TheRestartProject\RepairDirectory\Domain\Models
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class Suggestion
{
    use HasFactory;

    private $uid;
    private $field;
    private $value;

    /**
     * Get the field (of another entity) that this suggestion is for
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field that this suggestion is for
     *
     * @param string $field The value to set
     *
     * @return void
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * Get the value of the suggestion
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of the suggestion
     *
     * @param string $value The value to set
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the unique id of the suggestion
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the unique id of the suggestion
     *
     * @param int $uid The value to set
     *
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }
}
