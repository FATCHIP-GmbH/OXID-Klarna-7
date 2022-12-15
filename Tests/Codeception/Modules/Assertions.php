<?php


namespace TopConcepts\Klarna\Tests\Codeception\Modules;


use Codeception\Exception\ModuleException;
use Codeception\Module;
use Codeception\TestInterface;
use Exception;
use OxidEsales\TestingLibrary\Services\Library\DatabaseHandler;
use TopConcepts\Klarna\Core\KlarnaOrderManagementClient;
use TopConcepts\Klarna\Core\KlarnaUtils;
use TopConcepts\Klarna\Core\KlarnaClientBase;

class Assertions extends Module
{
    const NEW_ORDER_GIVEN_NAME      = "ÅåÆæØø";
    const NEW_ORDER_FAMILY_NAME     = "St.Jäöüm'es";
    const NEW_ORDER_STREET_ADDRESS  = "Karnapp 25";
    const NEW_ORDER_CITY            = "Hamburg";
    const NEW_ORDER_PHONE           = "30306900";
    const NEW_ORDER_DATE_OF_BIRTH   = "01011980";
    const NEW_ORDER_DISCOUNT        = "10";
    const NEW_ORDER_TRACK_CODE      = "12345";
    const NEW_ORDER_VOUCHER_NR      = "percent_10";
    const NEW_ORDER_ZIP_CODE        = "21079";

    public function after(TestInterface $test)
    {
        KlarnaOrderManagementClient::resetInstance();
        parent::after($test); // TODO: Change the autogenerated stub
    }

    /**
     * @return DatabaseHandler
     * @throws ModuleException
     */
    protected function getDbHandler() {
        /** @var ConfigLoader $configLoader */
        $configLoader = $this->getModule('\TopConcepts\Klarna\Tests\Codeception\Modules\ConfigLoader');
        return $configLoader->getDBHandler();
    }

    /**
     * @param $key
     * @return mixed|string|null
     * @throws ModuleException
     * @throws Exception
     */
    protected function getInputParam($key)
    {
        /** @var ConfigLoader $configLoader */
        $configLoader = $this->getModule('\TopConcepts\Klarna\Tests\Codeception\Modules\ConfigLoader');
        return $configLoader->getKlarnaDataByName($key);
    }

    /**
     * @param $orderId string - klarna order id
     * @return mixed
     */
    public function grabFromKlarnaAPI($orderId) {
        /** @var KlarnaOrderManagementClient|KlarnaClientBase $klarnaClient */
        $klarnaClient = KlarnaOrderManagementClient::getInstance();
        $orderData = $klarnaClient->getOrder($orderId);

        return $orderData;
    }

    /**
     * @param string $expectedStatus
     * @param null $inputDataMapper
     * @throws ModuleException
     */
    public function assertKlarnaData($expectedStatus = "AUTHORIZED", $inputDataMapper = null)
    {
        $klarnaId = $this->getDbHandler()
            ->query("SELECT TCKLARNA_ORDERID from `oxorder` ORDER BY `oxorderdate` DESC LIMIT 1")
            ->fetch(\PDO::FETCH_ASSOC);


        $this->seeOrderInDb($klarnaId['TCKLARNA_ORDERID'], $inputDataMapper);
        $this->seeInKlarnaAPI($klarnaId['TCKLARNA_ORDERID'], $expectedStatus);
    }

    /**
     * @param $klarnaId
     * @param null $inputDataMapper
     * @throws ModuleException
     */
    public function seeOrderInDb($klarnaId, $inputDataMapper = null) {
        if($inputDataMapper == null) {
            return;
        }

        $actualArray = $this->getDbHandler()
            ->query("SELECT * FROM oxorder WHERE TCKLARNA_ORDERID = '$klarnaId'")
            ->fetch(\PDO::FETCH_ASSOC);

        $this->assertInputStored($actualArray, $inputDataMapper);
    }

    /**
     * @param $klarnaId
     * @param string $expectedStatus
     * @param bool $differentDelShipping
     * @throws ModuleException
     */
    public function seeInKlarnaAPI($klarnaId, $expectedStatus = "AUTHORIZED", $differentDelShipping = false)
    {
        $klarnaOrderData = $this->grabFromKlarnaAPI($klarnaId);
        $oxidOrder = $this->getDbHandler()
            ->query("SELECT * FROM oxorder WHERE TCKLARNA_ORDERID = '$klarnaId'")
            ->fetch(\PDO::FETCH_ASSOC);

        $oxidOrderData = $this->prepareOxidData($oxidOrder, $expectedStatus);

        $billingDataMapper = [
            'OXBILLEMAIL' => 'email',
            'OXBILLFNAME' => 'given_name',
            'OXBILLLNAME' => 'family_name',
            'OXBILLZIP' => 'postal_code',
            'OXBILLCITY' => 'city',
            'OXBILLSTREET' => 'street_address',
            'OXBILLCOUNTRYID' => 'country',
        ];
        $this->assertDataEquals(
            $oxidOrderData,
            $klarnaOrderData['billing_address'],
            $billingDataMapper
        );

        if($differentDelShipping === true) {
            $shippingDataMapper = [
                'OXDELFNAME' => 'given_name',
                'OXDELLNAME' => 'family_name',
                'OXDELZIP' => 'postal_code',
                'OXDELCITY' => 'city',
                'OXDELCOUNTRYID' => 'country',
                'OXDELSTREET' => 'street_address',
            ];
            $this->assertDataEquals(
                $oxidOrderData,
                $klarnaOrderData['shipping_address'],
                $shippingDataMapper
            );
        }

        $orderDataMapper = [
            'OXTOTALORDERSUM' => 'order_amount',
            'FRAUD_STATUS' => 'fraud_status',
            'STATUS' => 'status'
        ];
        $this->assertDataEquals(
            $oxidOrderData,
            $klarnaOrderData,
            $orderDataMapper
        );
    }

    /**
     * @param $oxidRow
     * @param $expectedStatus
     * @return mixed
     * @throws ModuleException
     * @throws Exception
     */
    protected function prepareOxidData($oxidRow, $expectedStatus) {
        foreach($oxidRow as $colName => $val) {
            // replace COUNTRYID with OXISOALPHA2
            if (strpos($colName, 'COUNTRYID') !== false) {
                $country = $this->getDbHandler()
                    ->execSql("SELECT OXISOALPHA2 FROM oxcountry WHERE OXID = '$val'")
                    ->fetch();
                $oxidRow[$colName] = $country['OXISOALPHA2'];
            }
            // concat OXBILLSTREET, OXDELSTREET or OXSTREET with corresponding street number
            if ($colName == 'OXBILLSTREETNR' || $colName == 'OXDELSTREETNR' || $colName == 'OXSTREETNR') {
                $streetColName = substr($colName, 0 , -2);
                $oxidRow[$streetColName] .= ' ' . $val;
            }
            if ($colName == 'OXTOTALORDERSUM') {
                $oxidRow[$colName] = KlarnaUtils::parseFloatAsInt($val * 100);
            }
        }
        $oxidRow['STATUS'] = $expectedStatus;
        $oxidRow['FRAUD_STATUS'] = 'ACCEPTED';

        return $oxidRow;
    }

    /**
     * @param $expectedArray
     * @param $actualArray
     * @param $dataMapper
     */
    public function assertDataEquals($expectedArray, $actualArray, $dataMapper)
    {
        foreach ($dataMapper as $fieldName => $anotherFieldName) {
            // remove postal_code formatting
            if ($anotherFieldName === 'postal_code') {
                $actualArray[$anotherFieldName] = str_replace(' ', '', $actualArray[$anotherFieldName]);
                if(!empty($expectedArray[$anotherFieldName])) {
                    $expectedArray[$anotherFieldName] = str_replace(' ', '', $expectedArray[$anotherFieldName]);
                } else {
                    $expectedArray[$fieldName] = str_replace(' ', '', $expectedArray[$fieldName]);
                }
            }
            $this->assertEquals($expectedArray[$fieldName], $actualArray[$anotherFieldName]);
        }
    }

    /**
     * @param $actualArray
     * @param $dataMapper
     * @throws ModuleException
     */
    public function assertInputStored($actualArray, $dataMapper)
    {
        foreach ($dataMapper as $fieldName => $anotherFieldName) {
            $expectedArray[$fieldName] = $this->getInputParam($fieldName);
//            print_r("Comparing $fieldName = $expectedArray[$fieldName] to $anotherFieldName = $actualArray[$anotherFieldName]\n");
            $this->assertEquals($expectedArray[$fieldName], $actualArray[$anotherFieldName]);
        }
    }
}