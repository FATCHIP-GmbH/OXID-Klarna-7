<?php

use OxidEsales\Eshop\Application\Controller\Admin\PaymentMain;
use TopConcepts\Klarna\Component\KlarnaUserComponent;
use TopConcepts\Klarna\Controller\Admin\KlarnaConfiguration;
use TopConcepts\Klarna\Controller\Admin\KlarnaDesign;
use TopConcepts\Klarna\Controller\Admin\KlarnaEmdAdmin;
use TopConcepts\Klarna\Controller\Admin\KlarnaGeneral;
use TopConcepts\Klarna\Controller\Admin\KlarnaMessaging;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrderAddress;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrderArticle as KlarnaAdminOrderArticle;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrderList;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrderMain;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrderOverview;
use TopConcepts\Klarna\Controller\Admin\KlarnaOrders;
use TopConcepts\Klarna\Controller\Admin\KlarnaPaymentMain;
use TopConcepts\Klarna\Controller\Admin\KlarnaShipping;
use TopConcepts\Klarna\Controller\Admin\KlarnaStart;
use TopConcepts\Klarna\Controller\KlarnaUserController;
use TopConcepts\Klarna\Controller\KlarnaBasketController;
use TopConcepts\Klarna\Controller\KlarnaEpmDispatcher;
use TopConcepts\Klarna\Controller\KlarnaOrderController;
use TopConcepts\Klarna\Controller\KlarnaPaymentController;
use TopConcepts\Klarna\Controller\KlarnaThankYouController;
use TopConcepts\Klarna\Controller\KlarnaValidationController;
use TopConcepts\Klarna\Controller\KlarnaViewConfig;
use TopConcepts\Klarna\Core\Config;
use TopConcepts\Klarna\Model\KlarnaAddress;
use TopConcepts\Klarna\Model\KlarnaArticle;
use TopConcepts\Klarna\Model\KlarnaBasket;
use TopConcepts\Klarna\Model\KlarnaCountryList;
use TopConcepts\Klarna\Model\KlarnaOrder;
use TopConcepts\Klarna\Model\KlarnaOrderArticle;
use TopConcepts\Klarna\Model\KlarnaPayment;
use TopConcepts\Klarna\Model\KlarnaUser;
use TopConcepts\Klarna\Model\KlarnaUserPayment;
use TopConcepts\Klarna\Core\KlarnaShopControl;

use OxidEsales\Eshop\Application\Component\UserComponent;
use OxidEsales\Eshop\Application\Controller\Admin\OrderAddress;
use OxidEsales\Eshop\Application\Controller\Admin\OrderArticle as AdminOrderArticle;
use OxidEsales\Eshop\Application\Controller\Admin\OrderList;
use OxidEsales\Eshop\Application\Controller\Admin\OrderMain;
use OxidEsales\Eshop\Application\Controller\Admin\OrderOverview;
use OxidEsales\Eshop\Application\Controller\BasketController;
use OxidEsales\Eshop\Application\Controller\OrderController;
use OxidEsales\Eshop\Application\Controller\PaymentController;
use OxidEsales\Eshop\Application\Controller\ThankYouController;
use OxidEsales\Eshop\Application\Controller\UserController;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\UserPayment;
use OxidEsales\Eshop\Core\ViewConfig;
use TopConcepts\Klarna\Model\PaymentGateway;
use TopConcepts\Klarna\Core\KlarnaConsts;

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

$aModule = [
    'id' => 'tcklarna',
    'title' => 'Klarna Payments',
    'description' => [
        'de' => 'Egal was Sie verkaufen, unsere Produkte sind dafür gemacht, Ihren Kunden das beste Erlebnis zu bereiten. Das gefällt nicht nur Ihnen, sondern auch uns! Die Klarna Plugins werden stets auf Herz und Nieren geprüft und können ganz einfach durch Sie oder Ihre technischen Ansprechpartner aktiviert werden. Das nennen wir smoooth. Hier können Sie Klarna Payments aktivieren und anschließend genau die Zahlarten auswählen um Ihre Customer Journey zu optimieren. Erfahren Sie hier mehr zu Klarna für OXID: <a href="https://www.klarna.com/de/verkaeufer/oxid/">https://www.klarna.com/de/verkaeufer/oxid/</a> Und so einfach ist die Integration: <a href="https://hello.klarna.com/rs/778-XGY-327/images/How_to_OXID.mp4" target="_blank">Zum Video</a>',
        'en' => 'No matter what you sell, our products are made to give your customers the best purchase experience. This is not only smoooth for you - it is smoooth for us, too! Klarna plugins are always tested and can be activated by you or your technical contact with just a few clicks. That is smoooth. Here you can activate Klarna Payments and then select exactly the payment methods you want to optimize your customer journey. Find out more about Klarna for OXID: <a href="https://www.klarna.com/de/verkaeufer/oxid/" target="_blank">https://www.klarna.com/de/verkaeufer/oxid/</a> Integrating Klarna at OXID is easy as pie: <a href="https://hello.klarna.com/rs/778-XGY-327/images/How_to_OXID.mp4" target="_blank">to the video (click)</a>'
    ],
    'version' => '1.2.0',
    'author' => '<a href="https://www.fatchip.de" target="_blank">FATCHIP GmbH</a>',
    'thumbnail' => '/out/admin/src/img/klarna_lockup_black.jpg',
    'url' => 'https://www.klarna.com/de/verkaeufer/plattformen-und-partner/oxid/',
    'email' => 'oxid@klarna.com',

    'controllers' => [
        // klarna admin
        'KlarnaStart'                   => KlarnaStart::class,
        'KlarnaGeneral'                 => KlarnaGeneral::class,
        'KlarnaConfiguration'           => KlarnaConfiguration::class,
        'KlarnaDesign'                  => KlarnaDesign::class,
        'KlarnaEmdAdmin'                => KlarnaEmdAdmin::class,
        'KlarnaOrders'                  => KlarnaOrders::class,
        'KlarnaMessaging'               => KlarnaMessaging::class,
        'KlarnaShipping'                => KlarnaShipping::class,
        // controllers
        'KlarnaEpmDispatcher'           => KlarnaEpmDispatcher::class,
        'KlarnaValidate'                => KlarnaValidationController::class,
    ],
    'extend' => [
        // models
        Basket::class               => KlarnaBasket::class,
        User::class                 => KlarnaUser::class,
        Article::class              => KlarnaArticle::class,
        Order::class                => KlarnaOrder::class,
        Address::class              => KlarnaAddress::class,
        Payment::class              => KlarnaPayment::class,
        CountryList::class          => KlarnaCountryList::class,
        OrderArticle::class         => KlarnaOrderArticle::class,
        UserPayment::class          => KlarnaUserPayment::class,
        // controllers
        ThankYouController::class   => KlarnaThankYouController::class,
        ViewConfig::class           => KlarnaViewConfig::class,
        OrderController::class      => KlarnaOrderController::class,
        UserController::class       => KlarnaUserController::class,
        PaymentController::class    => KlarnaPaymentController::class,
        BasketController::class     => KlarnaBasketController::class,
        // admin
        OrderAddress::class         => KlarnaOrderAddress::class,
        OrderList::class            => KlarnaOrderList::class,
        AdminOrderArticle::class    => KlarnaAdminOrderArticle::class,
        OrderMain::class            => KlarnaOrderMain::class,
        OrderOverview::class        => KlarnaOrderOverview::class,
        PaymentMain::class          => KlarnaPaymentMain::class,
        //components
        UserComponent::class        => KlarnaUserComponent::class,

        OxidEsales\Eshop\Core\Config::class                         => Config::class,
        OxidEsales\Eshop\Application\Model\PaymentGateway::class    => PaymentGateway::class,
        OxidEsales\Eshop\Core\ShopControl::class                    => KlarnaShopControl::class
    ],
    'settings' => [
        //HiddenSettings
        ['name' => 'sKlarnaActiveMode', 'type' => 'str', 'value' => KlarnaConsts::MODULE_MODE_KP],
        ['name' => 'sKlarnaMerchantId', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaPassword', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaDefaultCountry', 'type' => 'str', 'value' => 'DE'],
        ['name' => 'sKlarnaFooterDisplay', 'type' => 'str', 'value' => '0'],
        ['name' => 'sKlarnaStripPromotion', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaMessagingScript', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaBannerPromotion', 'type' => 'str', 'value' => ''],
        ['name' => 'kp_order_id', 'type' => 'str', 'value' => ''],
        // Multilang Data
        ['name' => 'aarrKlarnaAnonymizedProductTitle', 'type' => 'aarr', 'value' => [
            'sKlarnaAnonymizedProductTitle_EN' => 'Product name',
            'sKlarnaAnonymizedProductTitle_DE' => 'Produktname'
        ]],
        ['name' => 'sKlarnaB2Option', 'type' => 'str', 'value' => 'B2C'],
        // Multilang Data Ende
        ['name' => 'aarrKlarnaISButtonStyle', 'type' => 'aarr', 'value' => [
            'variation' => 'klarna',
            'tagline' => 'light',
            'type' => 'pay',
        ]],
        ['name' => 'aarrKlarnaISButtonSettings', 'type' => 'aarr', 'value' => [
            'allow_separate_shipping_address' => 0,
            'date_of_birth_mandatory' => 0,
            'national_identification_number_mandatory' => 0,
            'phone_mandatory' => 0,
        ]],
        ['name' => 'iKlarnaActiveCheckbox', 'type' => 'str', 'value' => KlarnaConsts::EXTRA_CHECKBOX_NONE],
        ['name' => 'iKlarnaValidation', 'type' => 'str', 'value' => KlarnaConsts::NO_VALIDATION],
        ['name' => 'blIsKlarnaTestMode', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaLoggingEnabled', 'type' => 'bool', 'value' => false],
        ['name' => 'blKlarnaAllowSeparateDeliveryAddress', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaEnableAnonymization', 'type' => 'bool', 'value' => false],
        ['name' => 'blKlarnaSendProductUrls', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaSendImageUrls', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaMandatoryPhone', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaMandatoryBirthDate', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaEmdCustomerAccountInfo', 'type' => 'bool', 'value' => false],
        ['name' => 'blKlarnaEmdPaymentHistoryFull', 'type' => 'bool', 'value' => false],
        ['name' => 'blKlarnaEmdPassThrough', 'type' => 'bool', 'value' => false],
        ['name' => 'blKlarnaEnableAutofocus', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaEnablePreFilling', 'type' => 'bool', 'value' => true],
        ['name' => 'blKlarnaPreFillNotification', 'type' => 'bool', 'value' => true],
        ['name' => 'aarrKlarnaCreds', 'type' => 'aarr', 'value' => []],
        ['name' => 'aarrKlarnaTermsConditionsURI', 'type' => 'aarr', 'value' => []],
        ['name' => 'aarrKlarnaCancellationRightsURI', 'type' => 'aarr', 'value' => []],
        ['name' => 'aarrKlarnaShippingDetails', 'type' => 'aarr', 'value' => []],
        ['name' => 'blKlarnaDisplayBuyNow', 'type' => 'bool', 'value' => true],
        ['name' => 'sKlarnaFooterValue', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaCreditPromotionProduct', 'type' => 'str', 'value' => ''],
        ['name' => 'sKlarnaCreditPromotionBasket', 'type' => 'str', 'value' => ''],
        ['name' => 'aKlarnaDesign', 'type' => 'arr', 'value' => []],
        ['name' => 'aKlarnaDesignKP', 'type' => 'arr', 'value' => []],
    ],
    'events' => [
        'onActivate' => '\TopConcepts\Klarna\Core\KlarnaInstaller::onActivate',
        'onDeactivate' => '\TopConcepts\Klarna\Core\KlarnaInstaller::onDeactivate',
    ],
];
