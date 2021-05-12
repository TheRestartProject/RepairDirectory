<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum HideReason
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 */

class HideReason extends Enum
{
    const CLOSED_TEMPORARILY = "Closed temporarily";
    const CLOSED_PERMANENTLY = "Closed permanently";
    const QUALITY = "Doesn't meet quality criteria";
    const ASKED = "Asked to be removed";
    const OTHER = "Other";
}
