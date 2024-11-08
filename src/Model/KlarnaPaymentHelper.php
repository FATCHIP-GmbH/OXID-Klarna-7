<?php


namespace TopConcepts\Klarna\Model;


class KlarnaPaymentHelper
{
    /**
     * Oxid value of Klarna One payment
     *
     * @var string
     */
    const KLARNA_PAYMENT_ID = 'klarna';

    /**
     * Oxid value of Klarna Pay Now payment
     *
     * @var string
     */
    const KLARNA_PAYMENT_PAY_NOW = 'klarna_pay_now';

    /**
     * Oxid value of Klarna Pay Now payment
     *
     * @var string
     */
    const KLARNA_DIRECTDEBIT = 'klarna_directdebit';

    /**
     * Oxid value of Klarna Pay Now payment
     *
     * @var string
     */
    const KLARNA_CARD = 'klarna_card';

    /**
     * Oxid value of Klarna Pay Now payment
     *
     * @var string
     */
    const KLARNA_SOFORT = 'klarna_sofort';

    /**
     * Oxid value of Klarna Part payment
     *
     * @var string
     */
    const KLARNA_PAYMENT_SLICE_IT_ID = 'klarna_slice_it';

    /**
     * Oxid value of Klarna Invoice payment
     *
     * @var string
     */
    const KLARNA_PAYMENT_PAY_LATER_ID = 'klarna_pay_later';

    /**
     * Get list of Klarna payments ids
     *
     * @param null|string $filter KP - Klarna Payment Options
     * @return array
     */
    public static function getKlarnaPaymentsIds($filter = null)
    {
        if ($filter === 'KP') {
            return array(
                self::KLARNA_PAYMENT_ID,
                self::KLARNA_PAYMENT_SLICE_IT_ID,
                self::KLARNA_PAYMENT_PAY_LATER_ID,
                self::KLARNA_PAYMENT_PAY_NOW,
                self::KLARNA_DIRECTDEBIT,
                self::KLARNA_CARD,
                self::KLARNA_SOFORT,
            );
        }

        $allPayments = array(
            self::KLARNA_PAYMENT_ID,
            self::KLARNA_PAYMENT_SLICE_IT_ID,
            self::KLARNA_PAYMENT_PAY_LATER_ID,
            self::KLARNA_PAYMENT_PAY_NOW,
            self::KLARNA_DIRECTDEBIT,
            self::KLARNA_CARD,
            self::KLARNA_SOFORT,
        );

        return $filter === null ? $allPayments : [];
    }

    /**
     * Check if payment is Klarna payment
     *
     * @param string $paymentId
     * @return bool
     */
    public static function isKlarnaPayment($paymentId)
    {
        return in_array($paymentId, self::getKlarnaPaymentsIds());
    }

}
