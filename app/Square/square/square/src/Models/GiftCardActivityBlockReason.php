<?php

declare(strict_types=1);

namespace Square\Models;

use Exception;
use Square\ApiHelper;
use stdClass;

class GiftCardActivityBlockReason
{
    /**
     * The gift card is blocked because the buyer initiated a chargeback on the gift card purchase.
     */
    public const CHARGEBACK_BLOCK = 'CHARGEBACK_BLOCK';

    private const _ALL_VALUES = [self::CHARGEBACK_BLOCK];

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
