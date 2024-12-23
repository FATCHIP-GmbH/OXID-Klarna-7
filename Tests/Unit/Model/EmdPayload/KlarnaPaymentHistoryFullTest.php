<?php

namespace TopConcepts\Klarna\Tests\Unit\Model\EmdPayload;


use OxidEsales\Eshop\Application\Model\User;
use TopConcepts\Klarna\Model\EmdPayload\KlarnaPaymentHistoryFull;
use TopConcepts\Klarna\Tests\Unit\ModuleUnitTestCase;

/**
 * Class KlarnaPaymentHistoryFullTest
 * @package TopConcepts\Klarna\Tests\Unit\Models\EmdPayload
 * @covers \TopConcepts\Klarna\Model\EmdPayload\KlarnaPaymentHistoryFull
 */
class KlarnaPaymentHistoryFullTest extends ModuleUnitTestCase
{

    public function testGetPaymentHistoryFull()
    {
        $oUser = $this->getMockBuilder(User::class)->setMethods(['getId', 'isFake'])->getMock();
        $oUser->expects($this->any())
            ->method('getId')->willReturn('oxdefaultadmin');

        $oUser->expects($this->at(0))
            ->method('isFake')->willReturn(true);

        $oUser->expects($this->at(1))
            ->method('isFake')->willReturn(false);

        $paymentHistoryFull = $this->getMockBuilder(KlarnaPaymentHistoryFull::class)
            ->setMethods(['isPaymentDateRequired'])
            ->getMock();

        $history = $paymentHistoryFull->getPaymentHistoryFull($oUser);

        $expected = [
            "payment_history_full" => [],
        ];

        $this->assertEquals($expected, $history);

        $paymentHistoryFull->expects($this->any())
            ->method('isPaymentDateRequired')->willReturn(true);

        $history = $paymentHistoryFull->getPaymentHistoryFull($oUser);

        $oneYearAgo  = date(
            'Y-m-d',
            mktime(0, 0, 0, date("m"),
                date("d"),
                date("Y")-1)
        );

        $expected = [
            "payment_history_full" =>
                [
                    [
                        'unique_account_identifier' => "oxdefaultadmin",
                        'payment_option' => "other",
                        'number_paid_purchases' => 1,
                        'total_amount_paid_purchases' => 479,
                        'date_of_last_paid_purchase' => $oneYearAgo . "T16:07:50Z",
                        'date_of_first_paid_purchase' => $oneYearAgo . "T16:07:50Z",
                    ],
                ],
        ];

        $this->assertEquals($expected, $history);
    }
}
