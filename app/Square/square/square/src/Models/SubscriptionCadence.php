<?php

declare(strict_types=1);

namespace Square\Models;

use Exception;
use Square\ApiHelper;
use stdClass;

/**
 * Determines the billing cadence of a [Subscription]($m/Subscription)
 */
class SubscriptionCadence
{
    /**
     * Once per day
     */
    public const DAILY = 'DAILY';

    /**
     * Once per week
     */
    public const WEEKLY = 'WEEKLY';

    /**
     * Every two weeks
     */
    public const EVERY_TWO_WEEKS = 'EVERY_TWO_WEEKS';

    /**
     * Once every 30 days
     */
    public const THIRTY_DAYS = 'THIRTY_DAYS';

    /**
     * Once every 60 days
     */
    public const SIXTY_DAYS = 'SIXTY_DAYS';

    /**
     * Once every 90 days
     */
    public const NINETY_DAYS = 'NINETY_DAYS';

    /**
     * Once per month
     */
    public const MONTHLY = 'MONTHLY';

    /**
     * Once every two months
     */
    public const EVERY_TWO_MONTHS = 'EVERY_TWO_MONTHS';

    /**
     * Once every three months
     */
    public const QUARTERLY = 'QUARTERLY';

    /**
     * Once every four months
     */
    public const EVERY_FOUR_MONTHS = 'EVERY_FOUR_MONTHS';

    /**
     * Once every six months
     */
    public const EVERY_SIX_MONTHS = 'EVERY_SIX_MONTHS';

    /**
     * Once per year
     */
    public const ANNUAL = 'ANNUAL';

    /**
     * Once every two years
     */
    public const EVERY_TWO_YEARS = 'EVERY_TWO_YEARS';

    private const _ALL_VALUES = [
        self::DAILY,
        self::WEEKLY,
        self::EVERY_TWO_WEEKS,
        self::THIRTY_DAYS,
        self::SIXTY_DAYS,
        self::NINETY_DAYS,
        self::MONTHLY,
        self::EVERY_TWO_MONTHS,
        self::QUARTERLY,
        self::EVERY_FOUR_MONTHS,
        self::EVERY_SIX_MONTHS,
        self::ANNUAL,
        self::EVERY_TWO_YEARS,
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
