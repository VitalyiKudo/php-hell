<?php

declare(strict_types=1);

namespace Square\Models;

use Exception;
use Square\ApiHelper;
use stdClass;

/**
 * Indicates how the tax is applied to the associated line item or order.
 */
class OrderLineItemTaxType
{
    /**
     * Used for reporting only.
     * The original transaction tax type is currently not supported by the API.
     */
    public const UNKNOWN_TAX = 'UNKNOWN_TAX';

    /**
     * The tax is an additive tax. The tax amount is added on top of the price.
     * For example, an item with a cost of 1.00 USD and a 10% additive tax has a total
     * cost to the buyer of 1.10 USD.
     */
    public const ADDITIVE = 'ADDITIVE';

    /**
     * The tax is an inclusive tax. Inclusive taxes are already included
     * in the line item price or order total. For example, an item with a cost of
     * 1.00 USD and a 10% inclusive tax has a pretax cost of 0.91 USD
     * (91 cents) and a 0.09 (9 cents) tax for a total cost of 1.00 USD to
     * the buyer.
     */
    public const INCLUSIVE = 'INCLUSIVE';

    private const _ALL_VALUES = [self::UNKNOWN_TAX, self::ADDITIVE, self::INCLUSIVE];

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
