<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum SubnmissionStatus
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 */

class SubmissionStatus extends Enum
{
    const ADDED_TO_DIRECTORY = "Added to Directory";
    const DUPLICATE = "Duplicate";
    const OUTSIDE_AREA = "Outside Area";
    const SPAM = "Spam";
    const NOT_CONSIDERED_OTHER = "Not considered - other";
}
