<?php

declare(strict_types=1);

namespace Square\Models;

use Exception;
use Square\ApiHelper;
use stdClass;

/**
 * The list of possible reasons why a cardholder might initiate a
 * dispute with their bank.
 */
class DisputeReason
{
    /**
     * The cardholder claims that they were charged the wrong amount for the purchase.
     * To challenge this dispute, provide specific and concrete evidence that the cardholder agreed
     * to the amount charged.
     */
    public const AMOUNT_DIFFERS = 'AMOUNT_DIFFERS';

    /**
     * The cardholder claims that they attempted to return the goods or cancel the service.
     * To challenge this dispute, provide specific and concrete evidence to prove that the cardholder
     * is not due a refund and that the cardholder acknowledged your cancellation policy.
     */
    public const CANCELLED = 'CANCELLED';

    /**
     * The cardholder claims that they were charged twice for the same purchase.
     * To challenge this dispute, provide specific and concrete evidence that shows both charges are
     * legitimate and independent of one another.
     */
    public const DUPLICATE = 'DUPLICATE';

    /**
     * The cardholder claims that they did not make this purchase nor authorized the charge.
     * To challenge this dispute, provide specific and concrete evidence that proves that the cardholder
     * identity was verified at the time of purchase and that the purchase was authorized.
     */
    public const NO_KNOWLEDGE = 'NO_KNOWLEDGE';

    /**
     * The cardholder claims the product or service was provided, but the quality of the deliverable
     * did not align with the expectations of the cardholder based on the description.
     * To challenge this dispute, provide specific and concrete evidence that shows the cardholder is in
     * possession of the product as described or received the service as described and agreed on.
     */
    public const NOT_AS_DESCRIBED = 'NOT_AS_DESCRIBED';

    /**
     * The cardholder claims the product or service was not received by the cardholder within the
     * stated time frame.
     * To challenge this dispute, provide specific and concrete evidence to prove that the cardholder is
     * in possession of or received the product or service sold.
     */
    public const NOT_RECEIVED = 'NOT_RECEIVED';

    /**
     * The cardholder claims that they previously paid for this purchase.
     * To challenge this dispute, provide specific and concrete evidence that shows both charges are
     * legitimate and independent of one another or proof that you already provided a credit for the charge.
     */
    public const PAID_BY_OTHER_MEANS = 'PAID_BY_OTHER_MEANS';

    /**
     * The cardholder claims that the purchase was canceled or returned, but they have not yet received
     * the credit.
     * To challenge this dispute, provide specific and concrete evidence to prove that the cardholder is
     * not
     * due a refund and that they acknowledged your cancellation and/or refund policy.
     */
    public const CUSTOMER_REQUESTS_CREDIT = 'CUSTOMER_REQUESTS_CREDIT';

    /**
     * A chip-enabled card was not processed through a compliant chip-card reader (for example, it was
     * swiped
     * instead of dipped into a chip-card reader).
     * You cannot challenge this dispute because the payment did not comply with EMV security requirements.
     * For more information, see [What Is EMV?](https://squareup.com/emv)
     */
    public const EMV_LIABILITY_SHIFT = 'EMV_LIABILITY_SHIFT';

    private const _ALL_VALUES = [
        self::AMOUNT_DIFFERS,
        self::CANCELLED,
        self::DUPLICATE,
        self::NO_KNOWLEDGE,
        self::NOT_AS_DESCRIBED,
        self::NOT_RECEIVED,
        self::PAID_BY_OTHER_MEANS,
        self::CUSTOMER_REQUESTS_CREDIT,
        self::EMV_LIABILITY_SHIFT,
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
