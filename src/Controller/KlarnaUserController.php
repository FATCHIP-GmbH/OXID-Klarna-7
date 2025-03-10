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

namespace TopConcepts\Klarna\Controller;


use OxidEsales\Eshop\Application\Component\UserComponent;
use OxidEsales\Eshop\Application\Model\Country;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\ViewConfig;

class KlarnaUserController extends KlarnaUserController_parent
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        if ($amazonOrderId = Registry::get(Request::class)->getRequestParameter('amazonOrderReferenceId')) {
            Registry::getSession()->setVariable('amazonOrderReferenceId', $amazonOrderId);
        }
    }

    /**
     * @return mixed
     */
    public function getInvoiceAddress()
    {
        $result = parent::getInvoiceAddress();

        if (!$result) {
            $oCountry = oxNew(Country::class);
            $result['oxuser__oxcountryid'] = $oCountry->getIdByCode(Registry::getSession()->getVariable('sCountryISO'));
        }

        return $result;
    }
}