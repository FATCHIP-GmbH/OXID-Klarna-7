<?php

declare(strict_types=1);

namespace TopConcepts\Klarna\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614132959 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $this->extendDbTables($schema);
        $this->addAlterTables($schema);
    }

    /**
     * Extend klarna tables
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function extendDbTables(Schema $schema)
    {
        if (!$schema->hasTable('tcklarna_logs')) {
            $this->addSql("
                CREATE TABLE `tcklarna_logs` (
                      `OXID`          CHAR(32)
                                      CHARACTER SET latin1 COLLATE latin1_general_ci
                                   NOT NULL DEFAULT '',
                    
                      `OXSHOPID`      CHAR(32)
                                      CHARACTER SET latin1 COLLATE latin1_general_ci
                                   NOT NULL DEFAULT '',
                      `TCKLARNA_METHOD`      VARCHAR(128)
                                      CHARACTER SET utf8
                                   NOT NULL DEFAULT '',
                      `TCKLARNA_REQUESTRAW`  TEXT CHARACTER SET utf8
                                   NOT NULL,
                      `TCKLARNA_RESPONSERAW` TEXT CHARACTER SET utf8
                                   NOT NULL,
                      `TCKLARNA_DATE`        DATETIME
                                   NOT NULL DEFAULT '0000-00-00 00:00:00',
                      PRIMARY KEY (`OXID`),
                      KEY `TCKLARNA_DATE` (`TCKLARNA_DATE`)
                    )
                ENGINE = InnoDB
                DEFAULT CHARSET = utf8;
            ");
        }

        if (!$schema->hasTable('tcklarna_ack')) {
            $this->addSql("
                CREATE TABLE `tcklarna_ack` (
                      `OXID`       VARCHAR(32)
                                   CHARACTER SET latin1 COLLATE latin1_general_ci
                                            NOT NULL,
                      `KLRECEIVED` DATETIME NOT NULL,
                      PRIMARY KEY (`OXID`)
                    )
                ENGINE = InnoDB
                COMMENT ='List of all Klarna acknowledge requests'
                DEFAULT CHARSET = utf8;
            ");
        }

        if (!$schema->hasTable('tcklarna_anon_lookup')) {
            $this->addSql("
                CREATE TABLE `tcklarna_anon_lookup` (
                      `TCKLARNA_ARTNUM` VARCHAR(32) NOT NULL,
                      `OXARTID`  VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
                      PRIMARY KEY (`TCKLARNA_ARTNUM`)
                    )
                ENGINE = InnoDB
                COMMENT ='Mapping of annonymous article numbers to their oxids'
                DEFAULT CHARSET = utf8;
            ");
        }

        if (!$schema->hasTable('tcklarna_instant_basket')) {
            $this->addSql("
                CREATE TABLE `tcklarna_instant_basket` (
                    `OXID` VARCHAR(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
                    `BASKET_INFO` MEDIUMBLOB,
                    `STATUS`  VARCHAR(32) NOT NULL DEFAULT 'OPENED',
                    `TYPE` VARCHAR(32) NOT NULL DEFAULT '',
                    `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp',
                    PRIMARY KEY (`OXID`)
                )
                ENGINE = InnoDB
                DEFAULT CHARSET = utf8;
            ");
        }

        $updateOxPayments =
            array(
                "UPDATE `oxpayments` SET `TCKLARNA_PAYMENTOPTION`='card' WHERE `oxid`='oxidcreditcard';",
                "UPDATE `oxpayments` SET `TCKLARNA_PAYMENTOPTION`='direct banking' WHERE `oxid`='oxiddebitnote';",
            );
        foreach ($updateOxPayments as $sQuery) {
            $this->addSql($sQuery);
        }
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function addAlterTables(Schema $schema)
    {
        $aStructure = array(
            'oxorder'         => array(
                'TCKLARNA_MERCHANTID' => 'ADD COLUMN `TCKLARNA_MERCHANTID` VARCHAR(128)  DEFAULT \'\' NOT NULL',
                'TCKLARNA_SERVERMODE' => 'ADD COLUMN `TCKLARNA_SERVERMODE` VARCHAR(16) NOT NULL DEFAULT \'\'',
                'TCKLARNA_ORDERID'    => 'ADD COLUMN `TCKLARNA_ORDERID` VARCHAR(128)  DEFAULT \'\' NOT NULL',
                'TCKLARNA_SYNC'       => 'ADD COLUMN `TCKLARNA_SYNC` TINYINT UNSIGNED NOT NULL DEFAULT \'1\'',
            ),
            'oxorderarticles' => array(
                'TCKLARNA_TITLE'  => 'ADD COLUMN  `TCKLARNA_TITLE` VARCHAR(255) NOT NULL DEFAULT \'\'',
                'TCKLARNA_ARTNUM' => 'ADD COLUMN  `TCKLARNA_ARTNUM` VARCHAR(255) NOT NULL DEFAULT \'\'',
            ),
            'oxpayments'      => array(
                'TCKLARNA_PAYMENTTYPES'           => 'ADD COLUMN `TCKLARNA_PAYMENTTYPES` SET(\'payment\',\'checkout\') NULL DEFAULT \'\'',
                'TCKLARNA_EXTERNALNAME'           => 'ADD COLUMN `TCKLARNA_EXTERNALNAME` VARCHAR(255) NULL DEFAULT \'\'',
                'TCKLARNA_EXTERNALCHECKOUT'       => 'ADD COLUMN `TCKLARNA_EXTERNALCHECKOUT` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\'',
                'TCKLARNA_PAYMENTIMAGEURL'        => 'ADD COLUMN `TCKLARNA_PAYMENTIMAGEURL` VARCHAR(255) NULL DEFAULT \'\'',
                'TCKLARNA_PAYMENTIMAGEURL_1'      => 'ADD COLUMN `TCKLARNA_PAYMENTIMAGEURL_1` VARCHAR(255) NULL DEFAULT \'\'',
                'TCKLARNA_PAYMENTIMAGEURL_2'      => 'ADD COLUMN `TCKLARNA_PAYMENTIMAGEURL_2` VARCHAR(255) NULL DEFAULT \'\'',
                'TCKLARNA_PAYMENTIMAGEURL_3'      => 'ADD COLUMN `TCKLARNA_PAYMENTIMAGEURL_3` VARCHAR(255) NULL DEFAULT \'\'',
                'TCKLARNA_PAYMENTOPTION'          => 'ADD COLUMN `TCKLARNA_PAYMENTOPTION` SET(\'card\',\'direct banking\',\'other\') NOT NULL DEFAULT \'other\'',
                'TCKLARNA_EMDPURCHASEHISTORYFULL' => 'ADD COLUMN `TCKLARNA_EMDPURCHASEHISTORYFULL` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\'',
            ),
            'oxaddress'       => array(
                'TCKLARNA_TEMPORARY' => 'ADD COLUMN `TCKLARNA_TEMPORARY` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\'',
            ),
            'tcklarna_logs'   => array(
                'TCKLARNA_ORDERID'    => 'ADD COLUMN `TCKLARNA_ORDERID` VARCHAR(128) CHARACTER SET utf8 DEFAULT \'\' NOT NULL AFTER `OXID`',
                'TCKLARNA_MID'        => 'ADD COLUMN `TCKLARNA_MID` VARCHAR(50) CHARACTER SET utf8 NOT NULL AFTER `OXSHOPID`',
                'TCKLARNA_STATUSCODE' => 'ADD COLUMN `TCKLARNA_STATUSCODE` VARCHAR(16) CHARACTER SET utf8 NOT NULL AFTER `TCKLARNA_MID`',
                'TCKLARNA_URL'        => 'ADD COLUMN `TCKLARNA_URL` VARCHAR(256) CHARACTER SET utf8 AFTER `TCKLARNA_METHOD`',
            ),
            'tcklarna_ack'    => array(
                'TCKLARNA_ORDERID' => 'ADD COLUMN `TCKLARNA_ORDERID` VARCHAR(128) CHARACTER SET utf8 DEFAULT \'\' NOT NULL AFTER `OXID`, ADD KEY `TCKLARNA_ORDERID` (`TCKLARNA_ORDERID`)',
            ),
        );

        // ADD COLUMNS
        foreach ($aStructure as $sTableName => $aColumns) {

            $query = "ALTER TABLE `$sTableName` ";
            $first = true;

            foreach ($aColumns as $sColumnName => $queryPart) {
                if(!$schema->getTable($sTableName)->hasColumn($sColumnName)) {
                    if (!$first) {
                        $query .= ', ';
                    }
                    $query .= $queryPart;
                    $first = false;
                }
            }

            $this->addSql($query);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
