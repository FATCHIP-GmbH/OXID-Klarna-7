<?php
/**
 * Created by PhpStorm.
 * User: arekk
 * Date: 09.04.2018
 * Time: 14:41
 */

namespace TopConcepts\Klarna\Tests\Unit\Model;


use OxidEsales\Eshop\Application\Model\Payment;
use TopConcepts\Klarna\Model\KlarnaPayment;
use TopConcepts\Klarna\Model\KlarnaPaymentHelper;
use TopConcepts\Klarna\Tests\Unit\ModuleUnitTestCase;

class KlarnaPaymentTest extends ModuleUnitTestCase
{

    /**
     * @dataProvider isKPPaymentDataProvider
     */
    public function testIsKPPayment($paymentId, $expectedResult)
    {
        /** @var KlarnaPayment $oPayment */
        $oPayment = oxNew(Payment::class);
        $oPayment->setId($paymentId);

        $result = $oPayment->isKPPayment();
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function isKPPaymentDataProvider()
    {
        return [
            [KlarnaPayment::KLARNA_PAYMENT_ID, true],
            [KlarnaPayment::KLARNA_PAYMENT_CHECKOUT_ID, false],
            ['bestitamazon', false],
            ['oxidcashondel', false],
        ];
    }

    /**
     *
     */
    public function testGetKPMethods()
    {
        /** @var KlarnaPayment $oPayment */
        $oPayment = oxNew(Payment::class);
        $result   = $oPayment->getKPMethods();

        $this->assertTrue(count($result) === 1);
        $this->assertArrayHasKey(KlarnaPayment::KLARNA_PAYMENT_ID, $result);
    }

    /**
     * @dataProvider setActiveKPMethodsDataProvider
     * @param $aKPMEthods
     */
    public function testSetActiveKPMethods($aKPMEthods)
    {

        $this->setRequestParameter('kpMethods', $aKPMEthods);
        /** @var KlarnaPayment $oPayment */
        $oPayment = oxNew(Payment::class);
        $oPayment->setActiveKPMethods();

        foreach ($aKPMEthods as $oxId => $value) {
            $oPayment->load($oxId);
            $this->assertTrue($oPayment->oxpayments__oxactive->value == $value);
        }
    }

    /**
     * @return array
     */
    public function setActiveKPMethodsDataProvider()
    {
        return [
            [[
                 KlarnaPayment::KLARNA_PAYMENT_ID  => 0,
             ]],
            [[
                 KlarnaPayment::KLARNA_PAYMENT_ID  => 1,
             ]],
        ];
    }

    /**
     * @param $paymentId
     * @param $expectedResult
     * @dataProvider PaymentCategoryNameDataProvider
     */
    public function testGetPaymentCategoryName($paymentId, $expectedResult)
    {
        /** @var KlarnaPayment $oPayment */
        $oPayment = oxNew(Payment::class);
        $oPayment->setId($paymentId);
        $result = $oPayment->getPaymentCategoryName();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     *
     */
    public function PaymentCategoryNameDataProvider()
    {
        return [
            [KlarnaPayment::KLARNA_PAYMENT_ID, 'klarna'],
            [KlarnaPayment::KLARNA_PAYMENT_CHECKOUT_ID, false],
            ['bestitamazon', false],
            ['oxidcashondel', false],
        ];
    }

    /**
     * @dataProvider isKlarnaPaymentDataProvider
     */
    public function testIsKlarnaPayment($paymentId, $expectedResult)
    {
        $result = KlarnaPaymentHelper::isKlarnaPayment($paymentId);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function isKlarnaPaymentDataProvider()
    {
        return [
            [KlarnaPayment::KLARNA_PAYMENT_ID, true],
            [KlarnaPayment::KLARNA_PAYMENT_CHECKOUT_ID, true],
            ['bestitamazon', false],
            ['oxidcashondel', false],
        ];
    }


    /**testGetFlippedLangArray
     * @dataProvider KlarnaPaymentsIdDataProvider
     */
    public function testGetKlarnaPaymentsIds($filter, $expectedResult)
    {
        $result = KlarnaPaymentHelper::getKlarnaPaymentsIds($filter);
        $this->assertEquals($expectedResult, $result);

        $result = KlarnaPayment::getKlarnaPaymentsIds($filter);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function KlarnaPaymentsIdDataProvider()
    {
        $expectedResult_1 = [
            KlarnaPayment::KLARNA_PAYMENT_CHECKOUT_ID,
            KlarnaPayment::KLARNA_PAYMENT_ID,
        ];
        $expectedResult_2 = [
            KlarnaPayment::KLARNA_PAYMENT_ID,
        ];

        return [
            [null, $expectedResult_1],
            ['KP', $expectedResult_2],
            ['noResult', []],
        ];
    }

    /**
     * @dataProvider getBadgeUrlDataProvider
     * @param $sessionData
     * @param $klPaymentName
     * @param $expectedResult
     */
    public function testGetBadgeUrl($sessionData, $klPaymentName, $expectedResult)
    {
        $this->setSessionParam('klarna_session_data', $sessionData);

        $oPayment = $this->getMockBuilder(Payment::class)->setMethods(['getPaymentCategoryName'])->getMock();
        $oPayment->expects($this->once())->method('getPaymentCategoryName')->willReturn($klPaymentName);

        $result = $oPayment->getBadgeUrl();

        $this->assertEquals($expectedResult, $result);
    }

    public function getBadgeUrlDataProvider()
    {
        $sessionData = [
            'payment_method_categories' => [
                [
                    'identifier' => 'pay_later',
                    'name'       => 'Rechnung.',
                    'asset_urls' => [
                        'descriptive' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_later/descriptive/pink.svg',
                        'standard'    => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/pay_later/standard/pink.svg',
                    ],
                ],
                [
                    'identifier' => 'pay_over_time',
                    'name'       => 'Ratenkauf.',
                    'asset_urls' => [
                        'descriptive' => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/slice_it/descriptive/pink.svg',
                        'standard'    => 'https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/slice_it/standard/pink.svg',
                    ],
                ],
            ],
        ];

        return [
            [$sessionData, 'pay_later', $sessionData['payment_method_categories'][0]['asset_urls']['standard']],
            [$sessionData, 'pay_over_time', $sessionData['payment_method_categories'][1]['asset_urls']['standard']],
            [null, 'pay_over_time', "https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/slice_it/standard/pink.png"],
            [null, 'klarna_pay_now', "https://cdn.klarna.com/1.0/shared/image/generic/badge/de_de/klarna_pay_now/standard/pink.png"]
        ];
    }
}
