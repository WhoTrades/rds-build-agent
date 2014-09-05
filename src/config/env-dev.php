<?php
/**
 * Это файл с переопределением конфигруации для разработческого контура и который должен подключаться разработческой среде (dev)
 **/
// vdm: делаем до подключение env-test, т.к. в нем эта переменная уже используется
if (!isset($tld)) {
    $tld = 'dev';
}

require_once dirname(__FILE__) . '/env-test.php';


require_once __DIR__ . '/config.enterprisesystem.dev.php';

$this->debug_cold_cache_emulation = 1;

// настройки разных групп и сайтов
$this->group_partners_group_id = 30339159557;

//bn: configuration for techical notifications
$this->mailingSystem['technical']['trouble_email'] = 'dev@whotrades.net'; 	// email for report trouble form
$this->mailingSystem['technical']['form_email']	= 'dev@whotrades.net';		// email for feedback form
//$this->mailingSystem['technical']['wrong_phone_email']	= 'oops@whotrades.org;		// email for wrong phone form

// vdm: только на dev-контуре эта опция может быть выставлена в false
if ($dld === 'dev') {
    $this->dictionary_tasks_dont_process = false;
}

$this->developers_only_mail_filter_forbidden_receiver = "forbidden+dev@whotrades.org";

// azw: url game islands #WHO-3855
$this->islands_game_iframe_url = "http://fr-client.ostrovatest.finam.ru?locale=en&platform=wt";

$this->base_dir      = getcwd();
$this->root_dir = $this->base_dir . '/../..';

$this->css_preprocessor_command = 'node ' . $this->root_dir . '/misc/tools/css_preprocessor/rtl-converter.js';

// ad: PayU PS, on DEV ONLY YET #WHO-4577
$this->paymentsProcessingSystem['payu']['is_test'] = true;
$this->paymentsProcessingSystem['payu']['return_url'] = "https://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['payu']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/payu_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/payu/
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::LEARNING]['global']['available_payment_systems'][] = 'credit-card-3';

// ad: indonesian PS, on DEV ONLY YET #WHO-3616
$this->paymentsProcessingSystem['fasapay']['url'] = 'https://sandbox.fasapay.com/sci/';
$this->paymentsProcessingSystem['fasapay']['merchant'] = 'FPX8284';
$this->paymentsProcessingSystem['fasapay']['storeName'] = 'FINAM test';
$this->paymentsProcessingSystem['fasapay']['securityKey'] = 'kjdh93drf';
$this->paymentsProcessingSystem['fasapay']['return_url'] = "https://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['fasapay']['fail_url'] = "https://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['fasapay']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/fasapay_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/fasapay/
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD]['global']['available_payment_systems'][] = \WtConsts\PaySystems::FASAPAY_TEXT;
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::FASAPAY_TEXT]['hidden'] = false;

// ag: For testing #WTI-155
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::SBR_ONLINE_TEXT]['available'] = true;
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::SBR_ONLINE_TEXT]['hidden'] = false;

// ad: #WHO-4396
$this->paymentsProcessingSystem['dengionline']['project'] = 5789;
$this->paymentsProcessingSystem['dengionline']['source'] = 5789;
$this->paymentsProcessingSystem['dengionline']['securityKey'] = 'A/*37F17xI80xUvf+$9;%G;#+.65&n1';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXOTIC_OPTIONS][\WtConsts\PaySystems::DENGIONLINE]['project'] = 5790;
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXOTIC_OPTIONS][\WtConsts\PaySystems::DENGIONLINE]['source'] = 5790;

$this->finamru_location = 'http://stage.finam.ru/';
$this->integration_finamru_salt = 'skh3i(!oh39gn4902k2';

// bn: @since #WTT-63
$this->EnterpriseService['notificationGroups']['tradeRepeater'] = array(); // не шлем нотификацию для этой группы на дев-контуре

// ag: TODO Uncomment it for work with our cabinet on dev
//$this->old_cabinet_location = 'http://whotrades.{$tld}.whotrades.net/cabinet';

// ad: maintain payments systems config in sync with non-prod overrides
$this->paymentsProcessingSystem['allPaymentSystemsStaticData'] = $this->allPaymentSystemsStaticData;

$this->use_styles_cache = true;
$this->less_binary = '/usr/local/bin/strace -f -e trace=file -o {{strace_out_file}} /var/opt/node_modules/less/bin/lessc';
$this->stylus_binary = '/usr/local/bin/strace -f -e trace=file -o {{strace_out_file}} /usr/bin/stylus';

// Single Sign-on options
$this->CASLoginLocationUrl = 'http://crm.'.$dld.'.whotrades.net/singlelogin/?client_id=%s&return_url=%s&hash=%s&token=%s';
$this->CASLogoutLocationUrl = 'http://crm.'.$dld.'.whotrades.net/singlelogout/?return_url=%s';

// vdm: от tst контура отличается последним путем в адресе
$this->tradeWidget['location']['server'] = 'http://msa-ft-test.office.finam.ru/ft/test/dev1';

$this->assets_cache_dir = '/tmp/assets_cache/'.$dld.'/';

$this->cdn['use_cdn'] = false;
$this->cdn['use_host_without_cookie'] = false;

// bn: настройки для слива логов в грейлог, включаем отправку логов и конфигурируем транспорт
$this->grayLogSystem['errors']['enabled'] = true; // включаем отправку логов
$this->grayLogSystem['business']['enabled'] = true; // включаем отправку бизнес метрики в лог

// iv: since #WTS-1060
$this->news_groups = array(
    'ru' => 30448457051,  // finam.dev.whotrades.net
    'es' => 30448457051,
    'th' => 30448457051,
    'zh' => 30448457051,
    'ar' => 30448457051,
    'other' => 30448457051,
);

// dz: аккаунты которые показываются в торговалке для гостей @since #WTT-1472
$this->tradeWidget['guest'] = array(
    'showAccounts' => array(
        array(
            'login'        => 'twA1/106442',
            'password'     => '81da01d8db',
            'market'       => 'mct',
            'traderSystem' => 'TDMMA1',
        ),
    )
);


// bn: включаем слив логов в grayLog паралельно с отправкой в phpLogs @see lib\libcore\RequestHandler\Core::createDumpStorage
$this->phpLogsSystem['useGrayLogSystem'] = true;

$this->facebook['default_settings_group_id'] = null;
$this->facebook['default_settings_domain_list'] = null;


$this->socialImport['wordpress'] = array(
    'client_id' => 35892,
    'client_secret' => 'N0nI2Na4SwMuKV6D3RBdZU2pZbUx27rwAIf1vh3HGBDfGy3wAq9yYnFOWDMbaY5k'
);

$this->stmOverallEmail = 'dev-php@whotrades.org';

$this->tradePlatforms['whotrades_plus']['url']['demo'] = 'http://trading.etna.dev.whotrades.net/User/LogOnByToken';

$this->stockTwits['groupMap'] = [
    30839424372 => [
        'login' => 'ents',
        'password' => 'hello34',
    ],
    30469835084 => [
        'login' => 'ents',
        'password' => 'hello34',
    ],
];

// bn: на дев контуре делаем всех девелоперов способными продавать портфолио
$this->personsPortfolioForSale = $this->developers_person_obj_ids;

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!
