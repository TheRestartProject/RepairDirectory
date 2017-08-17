<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

/**
 * Enum Cluster
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class Cluster extends Enum
{

    const COMPUTERS_AND_HOME_OFFICE = "Computers and Home Office";
    const ELECTRONIC_GADGETS = "Electronic gadgets";
    const KITCHEN_AND_HOUSEHOLD = "Kitchen and household";
    const HOME_ENTERTAINMENT = "Home entertainment";

    /**
     * Returns the Categories that exist within this Cluster instance
     *
     * @return array
     */
    public function getCategories()
    {
        $value = $this->getValue();
        if ($value === self::COMPUTERS_AND_HOME_OFFICE) {
            return [
                Category::DESKTOP,
                Category::LAPTOP,
                Category::SHREDDER,
                Category::PRINTER_SCANNER
            ];
        }


        if ($value === self::ELECTRONIC_GADGETS) {
            return [
                Category::APPLE_IPHONE,
                Category::APPLE_IPAD,
                Category::CAMERA,
                Category::VIDEO_CAMERA,
                Category::HANDHELD_ENTERTAINMENT,
                Category::HEADPHONES,
                Category::MOBILE,
                Category::PC_ACCESSORY,
                Category::PORTABLE_RADIO,
                Category::TABLET
            ];
        }

        if ($value === self::KITCHEN_AND_HOUSEHOLD) {
            return [
                    Category::AIRCON_DEHUMIDIFIER,
                    Category::DECORATIVE_LIGHTS,
                    Category::FAN,
                    Category::HAIR_AND_BEAUTY,
                    Category::KETTLE,
                    Category::LAMP,
                    Category::POWER_TOOL,
                    Category::SMALL_KITCHEN_ITEM,
                    Category::TOASTER,
                    Category::TOY,
                    Category::VACUUM,
                    Category::WHITE_GOODS
                ];
        }

        if ($value === self::HOME_ENTERTAINMENT) {
            return [
                Category::FLAT_SCREEN,
                Category::HIFI,
                Category::INSTRUMENT,
                Category::NINTENDO_CONSOLE,
                Category::PLAYSTATION_CONSOLE,
                Category::PROJECTOR,
                Category::TV,
                Category::XBOX_CONSOLE
            ];
        }

        return [];
    }
}
