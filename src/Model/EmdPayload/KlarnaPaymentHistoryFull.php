<?php
/**
 * Copyright 2018 Klarna AB
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace TopConcepts\Klarna\Model\EmdPayload;


use TopConcepts\Klarna\Core\KlarnaConsts;
use TopConcepts\Klarna\Model\KlarnaEMD;
use OxidEsales\Eshop\Application\Model\PaymentList;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

/**
 * Class for Klarna payment history action handling
 *
 * @package Klarna
 */
class KlarnaPaymentHistoryFull
{
    /**
     * Max length of user ID (_sOXID value)
     *
     * @var int
     */
    const MAX_IDENTIFIER_LENGTH = 24;

    /**
     * Defines how many months in past should orders be taken in payment history
     *
     * @var int
     */
    const DATA_MONTHS_BACK_FULL_HISTORY = 24;

    /**
     * Payment statistics local storage
     *
     * @var array
     */
    protected $paymentStatistics = [];

    /**
     * Gets full payment history
     *
     * @param User $user
     * @return array
     */
    public function getPaymentHistoryFull(User $user)
    {
        $historyRecords = [];
        $paymentList = $this->getPaymentList();

        if ($this->hasPaymentHistory($user, $paymentList)) {
            $userId = $user->getId();
            foreach ($paymentList as $payment) {
                $historyRecords = $this->addPaymentStatisticsToHistory($historyRecords, $payment, $userId);
            }

            $historyRecords = $this->modifyDateFormats($historyRecords);
            $historyRecords = $this->modifyArrayFormat($historyRecords);
        }

        return [
            "payment_history_full" => $historyRecords,
        ];
    }

    /**
     * Checks if full payment history is posiible
     *
     * @param Payment $payment
     * @param $userId
     * @return bool
     */
    protected function isFullPaymentHistoryPossible(Payment $payment, $userId)
    {
        return $this->shouldPaymentBeIgnored($payment)
            && $this->shouldPaymentHistoryBeIgnored($payment)
            && $this->doesPaymentHasAnyOrder($payment, $userId);
    }

    /**
     * Returns all successful order statuses
     *
     * @return array
     */
    protected function getSuccessfulOrderStatuses()
    {
        return ['OK', 'SUCCESS', 'FINISHED', 'COMPLETED', 'PAID'];
    }

    /**
     * Gets payment statistics by given payment object and user ID
     *
     * @param Payment $payment
     * @param $userId
     * @return int
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function getPaymentStatistics(Payment $payment, $userId)
    {
        if (!isset($this->paymentStatistics[$payment->getId()])) {
            $this->paymentStatistics[$payment->getId()] = false;

            $oTableViewNameGenerator = oxNew(TableViewNameGenerator::class);
            $sOrderTable = $oTableViewNameGenerator->getViewName('oxorder');
            /** @var QueryBuilderFactoryInterface $oQueryBuilderFactory */
            $oQueryBuilderFactory = $this->getQueryBuilder();
            $oQueryBuilder = $oQueryBuilderFactory->create();
            $oQueryBuilder
                ->select(
                    'COUNT('.$sOrderTable.'.OXTOTALORDERSUM)',
                    'SUM('.$sOrderTable.'.OXTOTALORDERSUM)',
                    'MIN('.$sOrderTable.'.OXORDERDATE)',
                    'MAX('.$sOrderTable.'.OXORDERDATE)'
                )
                ->from($sOrderTable);

            $oQueryBuilder = $this->getPaymentQueryConditions($payment, $userId, $oQueryBuilder);
            $oQueryBuilder->SetMaxResults(1);
            $aResults = $oQueryBuilder->execute();
            $aResults = $aResults->fetchAllNumeric();

            $aResult = $aResults[0];

            if ($aResult[0]) {
                $pInfo = new \stdClass();
                $pInfo->purchaseCount = (int)$aResult[0];
                $pInfo->purchaseSum = (float)$aResult[1];
                $pInfo->dateFirstPaid = strtotime($aResult[2]);
                $pInfo->dateLastPaid = strtotime($aResult[3]);

                $this->paymentStatistics[$payment->getId()] = $pInfo;
            }
        }

        return $this->paymentStatistics[$payment->getId()];
    }

    /**
     * Gets parameters for where condition in SQL query
     *
     * @param Payment $payment
     * @param string $userId
     * @param QueryBuilderFactoryInterface $oQueryBuilder
     * @return QueryBuilderFactoryInterface $oQueryBuilder
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function getPaymentQueryConditions(Payment $payment, $userId, $oQueryBuilder)
    {
        $data_back = self::DATA_MONTHS_BACK_FULL_HISTORY;
        $dateBack = new \DateTime("-{$data_back}months");

        $oTableViewNameGenerator = oxNew(TableViewNameGenerator::class);
        $sOrderTable = $oTableViewNameGenerator->getViewName('oxorder');
        $oQueryBuilder
            ->where($sOrderTable.'.OXUSERID = :userId')
            ->setParameter(':userId', $userId)
            ->andWhere($sOrderTable.'.OXPAYMENTTYPE = :paymentId')
            ->setParameter(':paymentId', $payment->getId())
            ->andWhere($sOrderTable.'.OXSTORNO != 1')
            ->andWhere($sOrderTable.'.OXORDERDATE >= :orderdate')
            ->setParameter(':orderdate', $dateBack->format('Y-m-d h:i:s'));

        if (($st = $this->getSuccessfulOrderStatuses()) && is_array($st)) {
            $oQueryBuilder
                ->andWhere($sOrderTable.'.OXTRANSSTATUS IN (:succFullOrderStatuses)')
                ->setParameter(':succFullOrderStatuses', implode("','", $st));
        }

        if ($this->isPaymentDateRequired($payment)) {
            $oQueryBuilder
                ->andWhere($sOrderTable.'.OXPAID != "0000-00-00 00:00:00"');
        };

        return $oQueryBuilder;
    }

    /**
     * Checks is given payment has any orders
     *
     * @param Payment $payment
     * @param $userId
     * @return bool
     */
    protected function doesPaymentHasAnyOrder(Payment $payment, $userId)
    {
        $statistics = $this->getPaymentStatistics($payment, $userId);

        return ($statistics && $statistics->purchaseCount > 0);
    }

    /**
     * Checks if payment date is required
     *
     * @codeCoverageIgnore
     * @param Payment $payment
     * @return bool
     */
    protected function isPaymentDateRequired(Payment $payment)
    {
        return $payment->oxpayments__tcklarna_emdpurchasehistoryfull->value == KlarnaConsts::EMD_ORDER_HISTORY_PAID;
    }

    /**
     * Checks payment history should be ignored
     *
     * @param Payment $payment
     * @return bool
     */
    protected function shouldPaymentHistoryBeIgnored(Payment $payment)
    {
        return $payment->oxpayments__tcklarna_emdpurchasehistoryfull->value != KlarnaConsts::EMD_ORDER_HISTORY_NONE;
    }

    /**
     * Checks if payment is ignored
     *
     * @param Payment $payment
     * @return bool
     */
    protected function shouldPaymentBeIgnored(Payment $payment)
    {
        $ignorablePayments = ["oxempty"];

        return !in_array($payment->getId(), $ignorablePayments);
    }

    /**
     * Gets payments list
     *
     * @return PaymentList
     */
    protected function getPaymentList()
    {
        $oTableViewNameGenerator = oxNew(TableViewNameGenerator::class);
        $sTable = $oTableViewNameGenerator->getViewName('oxpayments');
        $query = "SELECT {$sTable}.* FROM {$sTable} WHERE {$sTable}.oxactive = 1 ";

        /** @var PaymentList $paymentList */
        $paymentList = oxNew(PaymentList::class);
        $paymentList->selectString($query);
        return $paymentList;
    }

    /**
     * Checks if user is not fake and there are active payments methods.
     *
     * @param User $user
     * @param $paymentList
     * @return bool
     * @throws \oxSystemComponentException
     */
    protected function hasPaymentHistory(User $user, $paymentList)
    {
        return !$user->isFake() && count($paymentList);
    }

    /**
     * Adds payment statistics to history
     *
     * @param $historyRecords
     * @param $payment
     * @param $userId
     * @return array
     */
    protected function addPaymentStatisticsToHistory($historyRecords, $payment, $userId)
    {
        if ($this->isFullPaymentHistoryPossible($payment, $userId)) {
            $paymentType = $payment->oxpayments__tcklarna_paymentoption->value;
            $paymentStatistics = $this->getPaymentStatistics($payment, $userId);

            if (!isset($historyRecords[$paymentType])) {
                $historyRecords[$paymentType] = [
                    "unique_account_identifier" => substr($userId, 0, self::MAX_IDENTIFIER_LENGTH),
                    "payment_option" => $payment->oxpayments__tcklarna_paymentoption->value,
                    "number_paid_purchases" => 0,
                    "total_amount_paid_purchases" => 0,
                    "date_of_last_paid_purchase" => $paymentStatistics->dateLastPaid,
                    "date_of_first_paid_purchase" => $paymentStatistics->dateFirstPaid,
                ];
            }

            $historyRecords[$paymentType]["number_paid_purchases"] += $paymentStatistics->purchaseCount;
            $historyRecords[$paymentType]["total_amount_paid_purchases"] += $paymentStatistics->purchaseSum;
            $historyRecords[$paymentType]["date_of_last_paid_purchase"]
                = max($paymentStatistics->dateLastPaid, $historyRecords[$paymentType]["date_of_last_paid_purchase"]);
            $historyRecords[$paymentType]["date_of_first_paid_purchase"]
                = min($paymentStatistics->dateFirstPaid, $historyRecords[$paymentType]["date_of_first_paid_purchase"]);
        }

        return $historyRecords;
    }

    /**
     * Modifies date formats of history records
     *
     * @param array $historyRecords
     * @return array
     */
    protected function modifyDateFormats($historyRecords)
    {
        foreach ($historyRecords as &$statistics) {
            // create from timestamp
            $dateLastPaid = new \DateTime('@' . $statistics["date_of_last_paid_purchase"]);
            $dateLastPaid->setTimezone(new \DateTimeZone('Europe/London'));
            $statistics["date_of_last_paid_purchase"] = $dateLastPaid->format(KlarnaEMD::EMD_FORMAT);

            // create from timestamp
            $dateFirstPaid = new \DateTime('@' . $statistics["date_of_first_paid_purchase"]);
            $dateFirstPaid->setTimezone(new \DateTimeZone('Europe/London'));
            $statistics["date_of_first_paid_purchase"] = $dateFirstPaid->format(KlarnaEMD::EMD_FORMAT);
        }

        return $historyRecords;
    }

    /**
     * Modifies history records
     *
     * @param array $historyRecords
     * @return array
     */
    protected function modifyArrayFormat($historyRecords)
    {
        $historyRecordsUpdated = [];
        foreach ($historyRecords as $statistics) {
            $historyRecordsUpdated[] = $statistics;
        }

        return $historyRecordsUpdated;
    }

    protected function getQueryBuilder() {
        $oContainer = ContainerFactory::getInstance()->getContainer();
        /** @var QueryBuilderFactoryInterface $oQueryBuilderFactory */
        return $oContainer->get(QueryBuilderFactoryInterface::class);
    }
}
