<?php
/**
 * Created by PhpStorm.
 * User: joaquim
 * Date: 23/08/2017
 * Time: 13:44
 */

namespace TheRestartProject\RepairDirectory\Application\QueryLanguage;


use MyCLabs\Enum\Enum;

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