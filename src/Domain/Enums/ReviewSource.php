<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Category
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class ReviewSource extends Enum
{
    const GOOGLE = "Google Map Search";
    const TRUSTPILOT = "Trustpilot";
    const FACEBOOK = "Facebook Reviews";
    const YELL = "Yell";
    const CHECKATRADE = "Checkatrade";
    const FREEINDEX = "Freeindex";
}
