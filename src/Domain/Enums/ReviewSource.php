<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum ReviewSource
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 * @author   Paul Fauth-Mayer <paul@outlandish.com>
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
    const OTHER = "Other";

    /**
     * Return a ReviewSource value based on a URL.
     * Simply checks if the domain of the URL matches any of the sources.
     *
     * @param string $reviewUrl The URL to derive the source from
     *
     * @return null|string
     */
    public static function derive($reviewUrl)
    {
        $reviewUrl = strtolower($reviewUrl);
        if (strpos($reviewUrl, 'google.co') !== false) {
            return self::GOOGLE;
        }
        if (strpos($reviewUrl, 'trustpilot.co') !== false) {
            return self::TRUSTPILOT;
        }
        if (strpos($reviewUrl, 'facebook.co') !== false) {
            return self::FACEBOOK;
        }
        if (strpos($reviewUrl, 'yell.co') !== false) {
            return self::YELL;
        }
        if (strpos($reviewUrl, 'checkatrade.co') !== false) {
            return self::CHECKATRADE;
        }
        if (strpos($reviewUrl, 'freeindex.co') !== false) {
            return self::FREEINDEX;
        }
        return self::OTHER;
    }
}
