<?php

namespace TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

use TheRestartProject\RepairDirectory\Domain\Models\Point;

/**
 * Class PointType
 *
 * A custom type adapter for Doctrine, mapping a Point in our Domain to a MySQL representation.
 *
 * @category Class
 * @package  TheRestartProject\RepairDirectory\Infrastructure\Doctrine\Types
 * @author   Joaquim d'Souza <joaquim@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 */
class PointType extends Type
{
    const POINT = 'point';

    /**
     * Return the type name
     *
     * @return string
     */
    public function getName()
    {
        return self::POINT;
    }

    /**
     * Return the SQL type that will be used to represent a Point
     *
     * @param array            $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform         The currently used database
     *                                           platform.
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'POINT';
    }

    /**
     * Convert a value retrieved from an SQL query to a Point
     *
     * @param mixed            $value    The value from the database
     * @param AbstractPlatform $platform The currently used database platform
     *
     * @return Point
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        list($longitude, $latitude) = sscanf($value, 'POINT(%f %f)');

        return new Point($latitude, $longitude);
    }

    /**
     * Convert a Point to its SQL representation
     *
     * @param mixed            $value    The Point to convert to SQL representation
     * @param AbstractPlatform $platform The currently used database
     *
     * @return mixed|string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Point) {
            $value = sprintf('POINT(%F %F)', $value->getLongitude(), $value->getLatitude());
        }

        return $value;
    }

    /**
     * Return true as the Point needs transforming when crossing the ORM/SQL boundary
     *
     * @return bool
     */
    public function canRequireSQLConversion()
    {
        return true;
    }

    /**
     * The SQL required to convert the raw column value into a value that can be read by
     * convertToPHPValue. In this case, it converts a POINT to a string.
     *
     * @param string           $sqlExpr  An SQL expression that returns a POINT
     * @param AbstractPlatform $platform The currently used database
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return sprintf('AsText(%s)', $sqlExpr);
    }

    /**
     * The SQL required to convert the value returned by convertToDatabaseValue into
     * the correct data type for the column (POINT).
     *
     * @param string           $sqlExpr  An string representation of a POINT
     * @param AbstractPlatform $platform The currently used database
     * 
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('PointFromText(%s)', $sqlExpr);
    }
}
