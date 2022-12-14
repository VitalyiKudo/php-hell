<?php

declare(strict_types=1);

namespace Square\Models;

use Exception;
use Square\ApiHelper;
use stdClass;

/**
 * The unit of volume used to measure a quantity.
 */
class MeasurementUnitVolume
{
    /**
     * The volume is measured in ounces.
     */
    public const GENERIC_FLUID_OUNCE = 'GENERIC_FLUID_OUNCE';

    /**
     * The volume is measured in shots.
     */
    public const GENERIC_SHOT = 'GENERIC_SHOT';

    /**
     * The volume is measured in cups.
     */
    public const GENERIC_CUP = 'GENERIC_CUP';

    /**
     * The volume is measured in pints.
     */
    public const GENERIC_PINT = 'GENERIC_PINT';

    /**
     * The volume is measured in quarts.
     */
    public const GENERIC_QUART = 'GENERIC_QUART';

    /**
     * The volume is measured in gallons.
     */
    public const GENERIC_GALLON = 'GENERIC_GALLON';

    /**
     * The volume is measured in cubic inches.
     */
    public const IMPERIAL_CUBIC_INCH = 'IMPERIAL_CUBIC_INCH';

    /**
     * The volume is measured in cubic feet.
     */
    public const IMPERIAL_CUBIC_FOOT = 'IMPERIAL_CUBIC_FOOT';

    /**
     * The volume is measured in cubic yards.
     */
    public const IMPERIAL_CUBIC_YARD = 'IMPERIAL_CUBIC_YARD';

    /**
     * The volume is measured in metric milliliters.
     */
    public const METRIC_MILLILITER = 'METRIC_MILLILITER';

    /**
     * The volume is measured in metric liters.
     */
    public const METRIC_LITER = 'METRIC_LITER';

    private const _ALL_VALUES = [
        self::GENERIC_FLUID_OUNCE,
        self::GENERIC_SHOT,
        self::GENERIC_CUP,
        self::GENERIC_PINT,
        self::GENERIC_QUART,
        self::GENERIC_GALLON,
        self::IMPERIAL_CUBIC_INCH,
        self::IMPERIAL_CUBIC_FOOT,
        self::IMPERIAL_CUBIC_YARD,
        self::METRIC_MILLILITER,
        self::METRIC_LITER,
    ];

    /**
     * Ensures that all the given values are present in this Enum.
     *
     * @param array|stdClass|null|string $value Value or a list/map of values to be checked
     *
     * @return array|null|string Input value(s), if all are a part of this Enum
     *
     * @throws Exception Throws exception if any given value is not in this Enum
     */
    public static function checkValue($value)
    {
        $value = json_decode(json_encode($value), true); // converts stdClass into array
        ApiHelper::checkValueInEnum($value, self::class, self::_ALL_VALUES);
        return $value;
    }
}
