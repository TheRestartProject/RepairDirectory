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
class Category extends Enum
{
    // Basic categories, as used by London.
    const APPLE_IPHONE = 'Apple iPhone';
    const APPLE_IPAD = 'Apple iPad';
    const AIRCON_DEHUMIDIFIER = 'Aircon/Dehumidifier';
    const DECORATIVE_LIGHTS = 'Decorative or safety lights';
    const DESKTOP = 'Desktop computer';
    const CAMERA = 'Digital Camera';
    const VIDEO_CAMERA = 'Video Camera';
    const FAN = 'Fan';
    const FLAT_SCREEN = 'Flat screen';
    const HAIR_AND_BEAUTY = 'Hair & Beauty item';
    const HANDHELD_ENTERTAINMENT = 'Handheld entertainment device';
    const HEADPHONES = 'Headphones';
    const HIFI = 'Hi-Fi';
    const KETTLE = 'Kettle';
    const LAMP = 'Lamp';
    const LAPTOP = 'Laptop';
    const MOBILE = 'Mobile/Smartphone';
    const INSTRUMENT = 'Musical instrument';
    const NINTENDO_CONSOLE = 'Nintendo console';
    const SHREDDER = 'Paper shredder';
    const PC_ACCESSORY = 'PC Accessory';
    const PLAYSTATION_CONSOLE = 'Playstation console';
    const PORTABLE_RADIO = 'Portable radio';
    const POWER_TOOL = 'Power tool';
    const PRINTER_SCANNER = 'Printer/scanner';
    const PROJECTOR = 'Projector';
    const SEWING_MACHINE = 'Sewing machine';
    const SMALL_KITCHEN_ITEM = 'Small kitchen item';
    const TABLET = 'Tablet';
    const TOASTER = 'Toaster';
    const TOY = 'Toy';
    const TV = 'TV';
    const VACUUM = 'Vacuum';
    const XBOX_CONSOLE = 'Xbox console';
    const WHITE_GOODS = 'White goods';

    // Additional categories for Wales.
    const REFRIGERATOR_FRIDGE = 'Refrigerator / fridge';
    const FREEZER = 'Freezer';
    const DISHWASHER = 'Dishwasher';
    const WASHING_MACHINE = 'Washing machine';
    const TUMBLE_DRYER = 'Tumble dryer';
    const COOKER_HOB_OVEN = 'Cooker / hob  / oven';

    const SEWING_REPAIRS = 'Sewing repairs';
    const CLOTHES_TEXTILES = 'Clothes / textiles';
    const SHOES_FOOTWEAR = 'Shoes / footwear';
    const BICYCLE_BIKE_CYCLE = 'Bicycle / bike / cycle';
    const FURNITURE_UPHOLSTERY = 'Furniture / upholstery';
}
