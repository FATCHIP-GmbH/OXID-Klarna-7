<?php

namespace TopConcepts\Klarna\Controller\Admin;


use OxidEsales\Eshop\Core\Request;
use TopConcepts\Klarna\Core\KlarnaConsts;
use TopConcepts\Klarna\Core\KlarnaUtils;
use OxidEsales\Eshop\Application\Model\Actions;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Field;

/**
 * Class Klarna_Config for module configuration in OXID backend
 */
class KlarnaDesign extends KlarnaBaseConfig
{

    protected $_sThisTemplate = '@tcklarna/admin/tcklarna_design';

    /**
     * Render logic
     *
     * @return string
     * @see admin/oxAdminDetails::render()
     */
    public function render()
    {
        parent::render();
        // force shopid as parameter
        // Pass shop OXID so that shop object could be loaded
        $sShopOXID = Registry::getConfig()->getShopId();

        $this->setEditObjectId($sShopOXID);

        if (KlarnaUtils::is_ajax()) {
            $output = $this->getMultiLangData();

            return Registry::getUtils()->showMessageAndExit(json_encode($output));
        }

        $from = '/' . preg_quote('-', '/') . '/';
        $locale = preg_replace($from, '_', strtolower(KlarnaConsts::getLocale(true)), 1);

        $this->addTplParam('mode', $this->getActiveKlarnaMode()->toString());
        $this->addTplParam('locale', $locale);
        $this->addTplParam('aKlarnaFooterImgUrls', KlarnaConsts::getFooterImgUrls());

        $this->addTplParam(
            'confaarrs',
            KlarnaUtils::getModuleSettingsAarrs($this->getViewDataElement('confaarrs'))
        );
        $this->addTplParam(
            'confbools',
            KlarnaUtils::getModuleSettingsBools($this->getViewDataElement('confbools'))
        );
        $this->addTplParam(
            'confstrs',
            KlarnaUtils::getModuleSettingsStrs($this->getViewDataElement('confstrs'))
        );

        return $this->_sThisTemplate;
    }
}