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

namespace TopConcepts\Klarna\Component;


use TopConcepts\Klarna\Core\KlarnaPayment;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\Eshop\Core\Registry;

/**
 * Class KlarnaOxCmp_User user component
 *
 * @package Klarna
 * @extend OxCmp_User
 */
class KlarnaUserComponent extends KlarnaUserComponent_parent
{
    /**
     * Login user without redirection
     */
    public function login_noredirect()
    {
        parent::login_noredirect();

        Registry::getSession()->setVariable("iShowSteps", 1);
        $oViewConfig = oxNew(ViewConfig::class);

        if ($oViewConfig->isKlarnaPaymentsEnabled()) {
            KlarnaPayment::cleanUpSession();
        }
    }
}
