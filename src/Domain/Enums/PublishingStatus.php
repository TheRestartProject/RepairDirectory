<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Category
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 * @author   Paul Fauth-Mayer <paul@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */

class PublishingStatus extends Enum
{
    const DRAFT = "Draft";
    const READY_FOR_REVIEW = "Ready for Review";
    const PUBLISHED = "Published";
    const HIDDEN = "Hidden";

}
