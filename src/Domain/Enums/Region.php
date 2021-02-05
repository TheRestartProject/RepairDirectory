<?php

namespace TheRestartProject\RepairDirectory\Domain\Enums;

use MyCLabs\Enum\Enum;

class Region extends Enum
{
    const LONDON = 'London';
    const WALES = 'Wales';
    
    const CATEGORIES = [
        self::LONDON => [
            Category::APPLE_IPHONE,
            Category::APPLE_IPAD,
            Category::AIRCON_DEHUMIDIFIER,
            Category::DECORATIVE_LIGHTS,
            Category::DESKTOP,
            Category::CAMERA,
            Category::VIDEO_CAMERA,
            Category::FAN,
            Category::FLAT_SCREEN,
            Category::HAIR_AND_BEAUTY,
            Category::HANDHELD_ENTERTAINMENT,
            Category::HEADPHONES,
            Category::HIFI,
            Category::KETTLE,
            Category::LAMP,
            Category::LAPTOP,
            Category::MOBILE,
            Category::INSTRUMENT,
            Category::NINTENDO_CONSOLE,
            Category::SHREDDER,
            Category::PC_ACCESSORY,
            Category::PLAYSTATION_CONSOLE,
            Category::PORTABLE_RADIO,
            Category::POWER_TOOL,
            Category::PRINTER_SCANNER,
            Category::PROJECTOR,
            Category::SEWING_MACHINE,
            Category::SMALL_KITCHEN_ITEM,
            Category::TABLET,
            Category::TOASTER,
            Category::TOY,
            Category::TV,
            Category::VACUUM,
            Category::XBOX_CONSOLE,
            Category::WHITE_GOODS
        ],
        self::WALES => [
            Category::APPLE_IPHONE,
            Category::APPLE_IPAD,
            Category::AIRCON_DEHUMIDIFIER,
            Category::DECORATIVE_LIGHTS,
            Category::DESKTOP,
            Category::CAMERA,
            Category::VIDEO_CAMERA,
            Category::FAN,
            Category::FLAT_SCREEN,
            Category::HAIR_AND_BEAUTY,
            Category::HANDHELD_ENTERTAINMENT,
            Category::HEADPHONES,
            Category::HIFI,
            Category::KETTLE,
            Category::LAMP,
            Category::LAPTOP,
            Category::MOBILE,
            Category::INSTRUMENT,
            Category::NINTENDO_CONSOLE,
            Category::SHREDDER,
            Category::PC_ACCESSORY,
            Category::PLAYSTATION_CONSOLE,
            Category::PORTABLE_RADIO,
            Category::POWER_TOOL,
            Category::PRINTER_SCANNER,
            Category::PROJECTOR,
            Category::SEWING_MACHINE,
            Category::SMALL_KITCHEN_ITEM,
            Category::TABLET,
            Category::TOASTER,
            Category::TOY,
            Category::TV,
            Category::VACUUM,
            Category::XBOX_CONSOLE,
            Category::WHITE_GOODS
        ]
    ];
}
