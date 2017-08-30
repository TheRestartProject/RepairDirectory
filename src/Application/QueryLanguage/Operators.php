<?php

namespace TheRestartProject\RepairDirectory\Application\QueryLanguage;

use MyCLabs\Enum\Enum;

/**
 * Enum Operators
 *
 * Used to represent Domain queries and translate these to Doctrine/SQL queries
 *
 * @category Enum
 * @package  TheRestartProject\RepairDirectory\Domain\Enums
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class Operators extends Enum
{
    const EQUAL = '=';
    const NOT_EQUAL = '!=';
    const GREATER_THAN_OR_EQUAL = '>=';
    const LESS_THAN_OR_EQUAL = '<=';
    const GREATER_THAN = '>';
    const LESS_THAN = '<';
    const CONTAINS = 'contains';
}