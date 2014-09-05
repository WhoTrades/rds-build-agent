<?php
// TODO: Удалить после окончания рефакторинга. Сейчас это файл для dev/tst контура, следующим шагом переименовать в tst
// ФАЙЛ ОСТАВ�?Л ПОКА ТОЛЬКО ЧТОБЫ НЕ ПОЛУЧ�?ТЬ ПРОБЛЕМ С МЕРЖЕМ

$this->paymentsProcessingSystem['api'] = array(
    'command' => "http://api.{$dld}.whotrades.net/api/payments-processing/command/",
    'system' => "http://api.{$dld}.whotrades.net/api/payments-processing/system/",
);

// memcache settings
$this->memcached['servers'] = array(
  "mc-0-1.comon.local:11211",
);
$this->memcached_session['servers'] = array(
  "mcs-0-1.comon.local:11212",
);
$this->facebookComSystem['memcached']['servers'] = $this->memcached['servers'];
$this->finamTenderSystem['cacheKvdpp']['memcached']['servers'] = $this->memcached['servers'];
$this->bfsSystem['memcached']['servers'] = $this->memcached['servers'];


// vdm: because whotrades.{$dld}.whotrades.net -- third level domain at .dev
if (isset($this->mode) && $this->mode == 'group' ) {
    $this->mode = 'main';
}
// domains
$this->main_domain = "{$dld}.whotrades.net";
// vdm: have to specify {$dld}.whotrades.net as base_domain as whotrades.vdm|whotrades.dev -- 3rd level domains
$this->base_domains[] = "{$dld}.whotrades.net";

// warl: Ticket #225
$this->serverName                  = $this->main_domain;
// lk: ticket #759
$this->from_domain                 = $this->main_domain;
$this->from_domain_other           = $this->main_domain;

$this->enable_russians = true;

// vdm: 2 all: place here local settings for common.mirtesen.dev

// finamTenderSystem
// vdm: N.B.: as session dispatcher is one for all developers it is impossible to specify own post back server
$this->finamTenderSystem['postBackLocation'] = "http://ftender.{$dld}.whotrades.net/";
$this->finamTenderSystem['serviceLocationUrl'] = "http://whotrades.{$dld}.whotrades.net/api/internal/services/ftender/";

$this->cometServer['host'] = 'cmt.comon.local';
$this->cometServer['port'] = 10010;

$this->activitySystem['cometServer']['host'] = 'cmt.comon.local';
$this->activitySystem['cometServer']['port'] = 10010;

$this->finamTenderSystem['cometServer']['host'] = 'cmt.comon.local';
$this->finamTenderSystem['cometServer']['port'] = 10010;

$this->finamTenderSystem['ipc']['cometServer']['host'] = 'cmt.comon.local';

// Default url for pool, check it with vdm/grishin before change
//$defaultPoolUrl = 'http://195.128.76.180/CommonEnglishDemo/'; // main ft server for developers
//$defaultPoolUrl = 'http://78.41.194.29/CommonEnglishDemo/'; // debug ft server for developers


$this->finamTenderSystem['services']['datafeed-demo']['location']['pool'] = array(
    'http://192.168.62.37/CommonEnglishDemo/',
);

$this->finamTenderSystem['services']['datafeed-real']['location']['pool'] = array(
    'http://192.168.62.37/CommonEnglishDemo/',
);

$this->finamTenderSystem['services']['forex-demo']['credentials']['login'] = 'Whotrades.MT4.LTD.Demo.Debug';
$this->finamTenderSystem['services']['forex-demo']['location']['pool'] = array(
    'http://192.168.62.37/CED/MT.Demo/',
);

$this->finamTenderSystem['services']['forex-real']['credentials']['login'] = 'Whotrades.MT4.LTD.Real.Debug';
$this->finamTenderSystem['services']['forex-real']['credentials']['password'] = 'bi6wevcnmo85';
$this->finamTenderSystem['services']['forex-real']['location']['pool'] = array(
    'http://192.168.62.37/CED/MT.Real/',
);

$this->finamTenderSystem['services']['xetra-demo']['transaq']['name'] = 'Msk.TransaqDev1';
$this->finamTenderSystem['services']['xetra-demo']['credentials']['login'] = 'WhoTrades.Xetra.Demo.Debug';
$this->finamTenderSystem['services']['xetra-demo']['location']['pool'] = array(
    'http://192.168.62.37/CED/Xetra.Demo/',
);
$this->finamTenderSystem['services']['xetra-demo']['balance'] = 'Transaq';


$this->finamTenderSystem['services']['xetra-real']['credentials']['login'] = 'WhoTrades.Xetra.Real.Debug';
$this->finamTenderSystem['services']['xetra-real']['location']['pool'] = array(
    'http://192.168.62.37/CED/Xetra.Real/',
);


$this->finamTenderSystem['services']['nysdaq-demo']['timezone'] = 'Etc/GMT+1';
$this->finamTenderSystem['services']['nysdaq-demo']['transaq']['name'] = 'Msk.TransaqDev1';
$this->finamTenderSystem['services']['nysdaq-demo']['credentials']['login'] = 'WhoTrades.USA.Demo.Debug';
$this->finamTenderSystem['services']['nysdaq-demo']['location']['pool'] = array(
    'http://192.168.62.37/CED/USA.Demo/',
);
$this->finamTenderSystem['services']['nysdaq-demo']['balance'] = 'Transaq';

// vdm: this is fake, it is not work
$this->finamTenderSystem['services']['nysdaq-real']['credentials']['login'] = 'WhoTrades.USA.Real.Debug';
$this->finamTenderSystem['services']['nysdaq-real']['location']['pool'] = array(
    'http://192.168.62.37/CED/USA.Real/',
);

// to authenticate whotrades.dev
$this->facebook['whotrades_dev']['applicationId'] = '176233045725329';
$this->facebook['whotrades_dev']['applicationSecret'] = 'd6801c3c4630569d5cb796ac85f7bd36';
$this->facebook["whotrades_{$dld}"]['domain'] = "whotrades.{$dld}.whotrades.net";

$this->facebook['whotrades_tst']['applicationId'] = '244558515676319';
$this->facebook['whotrades_tst']['applicationSecret'] = 'f30e588f50a1d9b3bf1127d9b4fafe86';

$this->facebook['whotrades_vdm']['applicationId'] = '152434804793258';
$this->facebook['whotrades_vdm']['applicationSecret'] = '5462951a96b424dec07eff96ae94c0ed';

$this->facebook['whotrades_vp']['applicationId'] = '104699989644237';
$this->facebook['whotrades_vp']['applicationSecret'] = 'f0776e2bfba68f24b537ce44978dbcb0';

$this->facebook['whotrades_ma']['applicationId'] = '201515816592533';
$this->facebook['whotrades_ma']['applicationSecret'] = 'd398f04e27a993f5ee380ddab6699cb0';

$this->facebook['whotrades_al']['applicationId'] = '559683960752701';
$this->facebook['whotrades_al']['applicationSecret'] = '87b8dade1c1375167a434130473afee3';

$this->facebook['whotrades_lk']['applicationId'] = '247226515353571';
$this->facebook['whotrades_lk']['applicationSecret'] = 'd628362f3406bedb3ab2ea682f84daee';

$this->facebook['whotrades_kz']['applicationId'] = '177325102395075';
$this->facebook['whotrades_kz']['applicationSecret'] = 'cb6ca257ffb59692c07dc61219330737';

$this->facebook['whotrades_iv']['applicationId'] = '500929079999235';
$this->facebook['whotrades_iv']['applicationSecret'] = 'a31b0d6530c8a765241fd510846e1519';

$this->facebook['whotrades_az']['applicationId'] = '401967103229786';
$this->facebook['whotrades_az']['applicationSecret'] = '5709b57b8e24752ffdf37cc35e9c5b61';

$this->facebook['whotrades_bn']['applicationId'] = '500674603378753';
$this->facebook['whotrades_bn']['applicationSecret'] = '92517185af539e54d0ea4a3455789074';

$this->facebook['whotrades_ag']['applicationId'] = '130107777193729';
$this->facebook['whotrades_ag']['applicationSecret'] = 'b8196565b597f6cc2e207d27b8645923';

$this->facebook['whotrades_an']['applicationId'] = '428196973968036';
$this->facebook['whotrades_an']['applicationSecret'] = '8fd9a85fc5f0b36486dca146a27a9c95';

$this->facebook['whotrades_de']['applicationId'] = '428196973968036';
$this->facebook['whotrades_de']['applicationSecret'] = '8fd9a85fc5f0b36486dca146a27a9c95';

$this->facebook['whotrades_azw']['applicationId'] = '1399300653631670';
$this->facebook['whotrades_azw']['applicationSecret'] = 'd8572ddbbdea7ad1dddf6cf236d5ad00';

$this->facebook['whotrades_tt']['applicationId'] = '794438477236450';
$this->facebook['whotrades_tt']['applicationSecret'] = '20d6eef8cd6e71988215b3ad6932284c';

$this->facebook['whotrades_sd']['applicationId'] = '796369930393071';
$this->facebook['whotrades_sd']['applicationSecret'] = '2ebc06224a16b85d20f5a875d0d600e2';

$this->facebook['whotrades_ak']['applicationId'] = '1521653274722371';
$this->facebook['whotrades_ak']['applicationSecret'] = '7e32535808bcfd66220b294ba0e24af4';

$this->facebook['exotic-options_al']['applicationId'] = '361219584013175';
$this->facebook['exotic-options_al']['applicationSecret'] = '260eee46cee4ca45543171d11ea28d4b';

$this->facebook['exotic-options_as']['applicationId'] = '361219584013175';
$this->facebook['exotic-options_as']['applicationSecret'] = '260eee46cee4ca45543171d11ea28d4b';

$this->facebook['exotic-options_an']['applicationId'] = '170527186471544';
$this->facebook['exotic-options_an']['applicationSecret'] = '9db0b00cc428ccfba86fed5b8416edf2';

$this->facebook['exotic-options_iv']['applicationId'] = '591380294237846';
$this->facebook['exotic-options_iv']['applicationSecret'] = 'f072e944179a0032a1e69bbba6d419a4';



$this->facebook['exotic-options_dev']['applicationId'] = '1399300653631670';
$this->facebook['exotic-options_dev']['applicationSecret'] = 'd8572ddbbdea7ad1dddf6cf236d5ad00';

$this->facebook['exotic-options_tst']['applicationId'] = '210762805759191';
$this->facebook['exotic-options_tst']['applicationSecret'] = '9a86c6ca953afb6bfaaf5ed93da5f8c4';

$this->facebook['exotic-options_vdm']['applicationId'] = '424119317700535';
$this->facebook['exotic-options_vdm']['applicationSecret'] = '7f52f826ea5bafb9e14ad52939b92f79';

$this->facebook['exotic-options_ag']['applicationId'] = '130107777193729';
$this->facebook['exotic-options_ag']['applicationSecret'] = 'b8196565b597f6cc2e207d27b8645923';

$this->facebook['exotic-options_azw']['applicationId'] = '1399300653631670';
$this->facebook['exotic-options_azw']['applicationSecret'] = 'd8572ddbbdea7ad1dddf6cf236d5ad00';

$this->facebook['defaultApplication'] = array(
    $this->group_exotic_options_group_id => "exotic-options_{$dld}",
    'default' => "whotrades_{$dld}",
);

$this->qqComSystem['api']['appId'] = '100285414';
$this->qqComSystem['api']['key'] = '4a0d79121d903076a3a569d9f143cbe4';
$this->qqComSystem['api']['redirectUrl'] = "http://Whotrades.{$tld}.whotrades.net/from-qq-com";

// vkontakte dev env
$this->vkontakte['whotrades_dev']['applicationId']     = 3152712;
$this->vkontakte['whotrades_dev']['applicationSecret'] = 'KvAOm1kMNDplnlB1S2kX';

$this->vkontakteEnv = 'whotrades_dev';

// vkontakte developers envs
$this->vkontakte['whotrades_vdm']['applicationId']     = 3152713;
$this->vkontakte['whotrades_vdm']['applicationSecret'] = 'kNFp4nQZAHEko7ekpfM3';


$this->vkontakte['whotrades_va']['applicationId']      = 3152933;
$this->vkontakte['whotrades_va']['applicationSecret']  = '0KI6jeOv78aAPPjg2ige';

// iv vkontakte app
$this->vkontakte['whotrades_iv']['applicationId']      = 3883295;
$this->vkontakte['whotrades_iv']['applicationSecret']  = 'DINKBFuBp10mplxwuQUh';

// message broker (SonicMQ) configuration
$this->finamTenderSystem['services']['messageBroker']['transaqIssueInit']['location']['soap'] = 'http://192.168.37.33:3510/wt_ii/';

$this->autofollow_objects = array(
    'en' => array(
        array('object_id' => 575232335),
    )
);

// bfs
$this->bfsSystem['allowed_ips']['delete'] = array(
    '192.168.52.0/25', // prod
    '192.168.136.2', //dev
    '192.168.61.28', //dev
    '192.168.61.21', //dev
    '192.168.61.19', //dev
);
$this->bfsSystem['servers'] = array(
    "get.storage.{$tld}.whotrades.net",
);

// upload
$this->uploadLocationUrl = "http://no_upload_service.{$tld}.whotrades.net/";

// vdm: TODO: fix me
$this->imageServers = array("no_old_bfs.{$tld}.whotrades.net");

$this->finamTenderSystem['debug_mode'] = 1;
$this->paymentsProcessingSystem['debug_mode'] = 1;

$this->developers_person_obj_ids[] = 79445381;  // Andrushkenko
$this->developers_person_obj_ids[] = 86041762;  // Leon Vinogradov
$this->developers_person_obj_ids[] = 414993504; // deemon (Dmitry Bogolyubov)
$this->developers_person_obj_ids[] = 578650936; // Dolzhenkov
$this->developers_person_obj_ids[] = 71789740;  // Dmsh's bots
$this->developers_person_obj_ids[] = 255525124; // Dmsh's bots
$this->developers_person_obj_ids[] = 259232534; // Dmitry Trost
$this->developers_person_obj_ids[] = 213298688; // Ilyas Miknaev
$this->developers_person_obj_ids[] = 17140993;  // Kolgakhinina
$this->developers_person_obj_ids[] = 366941138; // Kristina Lazebnik
$this->developers_person_obj_ids[] = 32452275;  // Prokhorov
$this->developers_person_obj_ids[] = 179498344; // Vladimir Ayupov
$this->developers_person_obj_ids[] = 71789740;  // dmsh+2012-07-10HBhgvh@whotrades.net
$this->developers_person_obj_ids[] = 426992733; // Gorlanov Anton
$this->developers_person_obj_ids[] = 842890961; // Arkadiy Sapronov
$this->developers_person_obj_ids[] = 975839544; // Anton Zhukov
$this->developers_person_obj_ids[] = 552961912; // Slava Golovlev
$this->developers_person_obj_ids[] = 520354220; // Афанасьев Антон
$this->developers_person_obj_ids[] = 625703483; // Александр Дубов
$this->developers_person_obj_ids[] = 951912861; // Александр Кузьмин
$this->developers_person_obj_ids[] = 142007329;  // Журавлев Дмитрий
$this->developers_person_obj_ids[] = 323384253;  // Глижинский Дмитрий
$this->developers_person_obj_ids[] = 234752020; // dtrost+6@whotrades.org
$this->developers_person_obj_ids[] = 51054052;  // Салават Даутов
$this->developers_person_obj_ids[] = 415781575;  // Варвара Попова

//warl: убрать после тестирования #WHO-2042
$this->developers_person_obj_ids[] = 737451889;
$this->developers_person_obj_ids[] = 992112348;

// vdm: обнуляем список ботов чтобы не сыпались на не те адреса
$this->mailingBots = array();
// vdm: боты vdm
$this->mailingBots['vdm'] = array(
    15311282, // @yandex.ru
);
//warl: боты Марата для тестирования рассылок market_news_*
$this->mailingBots['marat'] = array(
    230969311,
    637842271,
    894170857,
    129730744,
    742646046,
    161442936,
    500941052,
    18890586,
    156068280,
    820085622,
    308603482
);
// dz: боты dz
$this->mailingBots['dz'] = array(
    126696047, // @whotrades.org
    349768896, // @corp.finam.ru
);

//warl: админы блогов (like comon.ru) since: #WHO-2443
$this->admins_blogs_person_obj_ids = array(
    174202044
);

$this->qqComSystem['verification'] = '1407357040421453645667074214536654';

$this->finamTenderSystem['services']['transaq']['Msk.TransaqDev1']['timezone'] = 'Europe/Berlin';
$this->finamTenderSystem['services']['transaq']['Msk.TransaqDev1']['open_day_time'] = '07:45'; //09:45 Moscow
$this->finamTenderSystem['services']['transaq']['Msk.TransaqDev1']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['Msk.TransaqDev1']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['Msk.TransaqDev1']['close_week_time'] = 'Sat 00:00';

$this->translateMode = true;

$this->checkRenderDictionaryKeysCookie = 1;

//lk: show all languages in debug
$this->hidden_lcids = array();

// lk: on dev extended stat began early, than prod
$this->marketsSystemStat['startStoreProfitRatioDateTime'] = '2013-08-15';

// vmd: ssl related block: start
$this->ssl['enabled'] = false;
$this->cometServer['alias'] = null;
$this->cometServer['personal_channel_salt'] = 'kj234kj*!k4kn38ghwll';
$this->activitySystem['cometServer']['alias'] = null;
$this->finamTenderSystem['cometServer']['alias'] = null;
// vmd: ssl related block: end


$this->group_thai_edu_group_id = 30861139202;
$this->group_guru_group_id = 30256536396;
$this->group_algo_trading_group_id = 30052000597;
$this->group_finam_group_id = 30448457051;
//an: mma.whotrades.com
$this->group_mma_group_id = 30937503660;

// dz: #WTT-1146
$this->group_contest_indian_olympic_group_id = 30586258589;

//lk: since #WHO-3583
$this->learning['payment']['course']['salt'] = 'lgiVDss^0$aB47wPoBT8TFYw4tHDYhpSQ*P1crqB';

// vdm+sl: this is dev so no 2nd level domains
$this->group_domain_name_3rd_level_to_2nd_level = false;

$this->finamTenderSystem['services']['jtrade']['loginPostfix'] = '@dev.whotrades.net';
$this->finamTenderSystem['services']['jtrade']['platforms']['Msk.TransaqDev1.Xetra'] = array(
    'BaseRecord' => 'brMsg::dev.Whotrade.Portfolio.dev1',
    'TransaqRecord' => 'brMsg::dev.Whotrade.Transaq.dev1',
    'Source' => 'DEV1',
    'AccountType' => 512,
);
$this->finamTenderSystem['services']['jtrade']['platforms']['Msk.TransaqDev1.Nysdaq'] = array(
    'BaseRecord' => 'brMsg::dev.Whotrade.Portfolio.dev1',
    'TransaqRecord' => 'brMsg::dev.Whotrade.Transaq.dev1',
    'Source' => 'DEV1',
    'AccountType' => 1024,
);
$this->finamTenderSystem['services']['jtrade']['map']['xetra-demo'] = 'Msk.TransaqDev1.Xetra';
$this->finamTenderSystem['services']['jtrade']['map']['nysdaq-demo'] = 'Msk.TransaqDev1.Nysdaq';

// lk: TradeSystemName config moved to config.enterprisesystem.tst since 23/09/2013

//sl
$this->finamTenderSystem['TradeSystemClient']['Rpc']['url'] = $this->finamTenderSystem['serviceLocationUrl'].'api/rpc/json/';


$this->marketwatch_default_list['nysdaq'] = array(
    81329, //"PLUM CREEK TIMB REIT"
    80713 // "PROLOGIS REIT"
);

$this->order_fake_instrument_specific_fields = array(
    41112 => array( //Apple
        'condition_price' => 297.95,
        'operation_price' => 297.95
    ),
    66736 => array( // Google
        'condition_price' => 483,
        'operation_price' => 483
    ),
    75216 => array( //EUR vs USD
        'opening_rate' => 1.30610
    )
);

$this->phpLogsSystem['location'] = '/var/log/phplogs/';

// dmsh for quickly testing
$this->smartNotificationList['Alright'] = array('settings' => array('percentageOfExcess' => 1));
$this->smartNotificationList['EverythingIsBad'] = array('settings' => array('percentageOfExcess' => 10));
$this->smartNotificationList['OrderCount'] = array('settings' => array('OrderCountLimit' => 10));

$this->smartNotificationList['OrderLossCount'] = array('settings' => array('OrderLossCountLimit' => 10));
$this->smartNotificationList['OrderProfitCount'] = array('settings' => array('OrderProfitCountLimit' => 5));

$this->smartNotificationWeeklyActivitiesPeriod = 'last week'; //Monday

//warl: since #WTS-125
$this->smartNotificationRatedBlogPosts['personIdNotification'] = array(575232335); // warl@nasvete.ru
$this->smartNotificationRatedBlogPosts['enabled'] = false;

// ----- And dev config for Enterprise Service ----- //

// ----  Google Analitycs Settings --------
$this->google_analytics_id = 'UA-27007356-1';
$this->google_analytics_domain_hash = '105613637'; //value get from cookie name __utmc

$this->MonitoringCreateRealAccount['email'] = 'dev@whotrades.net';

$this->paymentsProcessingSystem['paypal']['url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
$this->paymentsProcessingSystem['paypal']['business'] = 'warl@whotrades.net';
$this->paymentsProcessingSystem['paypal']['callback']['url'] = "http://api.{$dld}.whotrades.net/api/payments-processing/paypal/";
$this->paymentsProcessingSystem['paypal']['callback']['notify_validate_url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

// vdm: Тестовая карта: 4665120800191896, дата: 03/14, cvc2 583
// vdm: callback url задается письмом Kostylev_af@masterbank.ru: http://api.dev.whotrades.net/api/payments-processing/masterbank/
// vdm: временно для проверки WHO-613
$this->paymentsProcessingSystem['masterbank']['url'] = 'http://web3ds2.masterbank.ru/cgi-bin/cgi_link';
$this->paymentsProcessingSystem['masterbank']['api_url'] = 'http://web3ds2.masterbank.com/cgi-bin/cgi_link';
// $this->paymentsProcessingSystem['masterbank']['url'] = 'http://web3ds2.masterbank.ru/cgi-bin/cgi_link';
// $this->paymentsProcessingSystem['masterbank']['api_url'] = 'http://web3ds2.masterbank.ru/cgi-bin/cgi_link';
$this->paymentsProcessingSystem['masterbank']['terminal'] = '10000142';
$this->paymentsProcessingSystem['masterbank']['merchant'] = '100000000000142';
//$this->paymentsProcessingSystem['masterbank']['currency'] = array('RUB');

$this->paymentsProcessingSystem['masterbank']['merchant_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/generic";
$this->paymentsProcessingSystem['masterbank']['generic_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/generic";

// vdm: callback url задается на secure.payonlinesystem.com: http://api.dev.whotrades.net/api/payments-processing/payonline/
$this->paymentsProcessingSystem['payonline']['merchant'] = 7371;
$this->paymentsProcessingSystem['payonline']['enabled'] = true;
$this->paymentsProcessingSystem['payonline']['url'] = 'https://secure.payonlinesystem.com/en/payment/';
// vdm: вынужден весь массив переопределять, т.к. на dev не будет работать prod url и лучше будет меньше переводов, чем ошибки
$this->paymentsProcessingSystem['payonline']['lcid2UrlMap'] = array(
    'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
);
$this->paymentsProcessingSystem['payonline']['securityKey'] = '99193361-57cf-4f48-9ebe-3f75de740c84';
$this->paymentsProcessingSystem['payonline']['return_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['payonline']['fail_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/cancel";

$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD][\WtConsts\PaySystems::PAYONLINE]['merchant'] = 7371;
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD][\WtConsts\PaySystems::PAYONLINE]['securityKey'] = '99193361-57cf-4f48-9ebe-3f75de740c84';

//$this->paymentsProcessingSystem['moneybookers']['url'] = 'https://www.moneybookers.com/app/test_payment.pl';
$this->paymentsProcessingSystem['moneybookers']['callback']['url'] = "http://whotrades.{$tld}.whotrades.net/api/payments-processing/moneybookers/";
$this->paymentsProcessingSystem['moneybookers']['pay_to_email'] = 'loonyway@yahoo.com';
//$this->paymentsProcessingSystem['moneybookers']['pay_from_email'] = 'leoforce@yandex.ru';
$this->paymentsProcessingSystem['moneybookers']['return_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['moneybookers']['fail_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/cancel";
//$this->paymentsProcessingSystem['moneybookers']['min'] = 0.01;
//$this->paymentsProcessingSystem['moneybookers']['max'] = 1000000;

//$this->paymentsProcessingSystem['qiwi']['password'] = 'test';
$this->paymentsProcessingSystem['qiwi']['enabled'] = true;
//$this->paymentsProcessingSystem['qiwi']['min'] = 0.01;

$this->paymentsProcessingSystem['algocharge']['merchant'] = 254115;
$this->paymentsProcessingSystem['algocharge']['enabled'] = true;
$this->paymentsProcessingSystem['algocharge']['url'] = 'http://demo.allcharge.com/Webi/html/interface.aspx';
$this->paymentsProcessingSystem['algocharge']['merchantName'] = 'Algo'; // needed for testing
$this->paymentsProcessingSystem['algocharge']['callback']['url'] = "http://whotrades.{$tld}.whotrades.net/api/payments-processing/algocharge/";
$this->paymentsProcessingSystem['algocharge']['return_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['algocharge']['return_url_wt_trader'] = "https://whotrades.{$dld}.whotrades.net/cabinet/payments/%invoice_id%/status/?command=status";
$this->paymentsProcessingSystem['algocharge']['return_url_wt_person']  = "https://whotrades.{$dld}.whotrades.net/payments/%invoice_id%/status/?command=status";
$this->paymentsProcessingSystem['algocharge']['fail_url'] = "http://whotrades.{$dld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['algocharge']['api_url'] = 'http://demo.allcharge.com/Verify/VerifyNotification.aspx';
$this->paymentsProcessingSystem['algocharge']['api_url_sync'] = 'http://demo.allcharge.com/mi/html/synchronize.aspx';

//array_splice($this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD]['global']['conversions'], 0, 1);
//$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD]['global']['payment_systems_source'][\WtConsts\PaySystems::CHINA_UNION_PAY] = 'algocharge';

// ad: PSB #WTT-196
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::PSB_WALLET_TEXT]['available'] = true;
$this->paymentsProcessingSystem['psb']['enabled'] = true;
$this->paymentsProcessingSystem['psb']['url'] = 'http://193.200.10.117:8080/cgi-bin/cgi_link'; // ad: для функционала REFUND порт открывался заявкой 80632
$this->paymentsProcessingSystem['psb']['merchant'] = '790367686219999';
$this->paymentsProcessingSystem['psb']['terminal'] = 79036862;
$this->paymentsProcessingSystem['psb']['securityKey'] = 'C50E41160302E0F5D6D59F1AA3925C45';
$this->paymentsProcessingSystem['psb']['return_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/generic?from_ps=psb";
$this->paymentsProcessingSystem['psb']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/generic?from_ps=psb";
$this->paymentsProcessingSystem['psb']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/psb_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/psb/
$this->paymentsProcessingSystem['psb']['api_url_sync'] = 'https://rs.psbank.ru:4443/cgi-bin/ecomm_check_test';
$this->paymentsProcessingSystem['psb']['proxy_url'] = "http://wt-wallet.{$tld}.whotrades.net";
$this->paymentsProcessingSystem['psb']['proxy_cancel_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";

$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXOTIC_OPTIONS][\WtConsts\PaySystems::PSB]['return_url'] = "http://wt-wallet.{$tld}.whotrades.net/wallet/payments/result?from_ps=psb";
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::TRADE_REPEATER][\WtConsts\PaySystems::PSB]['return_url'] = "http://wt-wallet.{$tld}.whotrades.net/wallet/payments/result?from_ps=psb";

$this->paymentsProcessingSystem['local_aggregator'][\PaymentsProcessingSystem\LocalAggregators::WTWALLET]['use3card'] = true;

// ad: RBK Money PS #WTT-185
$this->paymentsProcessingSystem['rbkmoney']['enabled'] = true;
$this->paymentsProcessingSystem['rbkmoney']['url'] = 'https://rbkmoney.ru/acceptpurchase.aspx';
$this->paymentsProcessingSystem['rbkmoney']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['rbkmoney']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['rbkmoney']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/rbkmoney_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/rbkmoney/
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::RBK_MONEY_TEXT]['hidden'] = false;
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::RBK_MONEY_TEXT]['agregator'] = 'rbkmoney';

// vdm: callback url задается на secure.onpay.ru: http://api.dev.whotrades.net/api/payments-processing/onpay/
// warl: login/password: warl@whotrades.net/1234567890

$this->paymentsProcessingSystem['onpay']['enabled'] = true;
$this->paymentsProcessingSystem['onpay']['url'] = 'https://secure.onpay.ru/pay/www_whotrades_dev';

$this->paymentsProcessingSystem['onpay']['min']['USD'] = 0.15;
$this->paymentsProcessingSystem['onpay']['min']['EUR'] = 0.15;
$this->paymentsProcessingSystem['onpay']['min']['RUB'] = 10;

$this->paymentsProcessingSystem['onpay']['securityKey'] = 'LeEWGr1neC6';

//warl: callback url управляется через email на eug@pillonet.com: http://api.dev.whotrades.net/api/payments-processing/astech/
$this->paymentsProcessingSystem['astech']['store_id']['china-union-pay'] = 'TestStore1';
$this->paymentsProcessingSystem['astech']['brand_id'] = 'T895T_ALFArm1';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_SYC][\WtConsts\PaySystems::ASTECH]['store_id']['china-union-pay'] =
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL_SYC][\WtConsts\PaySystems::ASTECH]['store_id']['china-union-pay'] =
        'WhotradesSycTest';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_SYC][\WtConsts\PaySystems::ASTECH]['brand_id'] =
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL_SYC][\WtConsts\PaySystems::ASTECH]['brand_id'] =
        'T1461T_ALFArm3';

$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WEBINARS]['global']['success_url'] = 'http://kirienko.msa-finamdev1.finam.ru/webinar/list0000E00001/default.asp';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WEBINARS]['global']['fail_url'] = 'http://kirienko.msa-finamdev1.finam.ru/webinar/list0000E00002/default.asp';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WEBINARS]['global']['generic_url'] = 'http://kirienko.msa-finamdev1.finam.ru/webinar/list0000E00003/default.asp';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WEBINARS]['global']['merchant_name'] = 'Вебинары';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WEBINARS]['global']['merchant_url'] = 'http://kirienko.msa-finamdev1.finam.ru/webinar/main/default.asp';

$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['global']['success_url'] = 'http://finameumain.msa-webtest1.finam.ru/FundsDeposit/PaymentSuccess/';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['global']['return_url'] = 'http://finameumain.msa-webtest1.finam.ru/FundsDeposit/PaymentSuccess/';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['global']['fail_url'] = 'http://finameumain.msa-webtest1.finam.ru/FundsDeposit/PaymentFail/';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['global']['generic_url'] = 'http://finameumain.msa-webtest1.finam.ru/FundsDeposit/PaymentGeneric/';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['global']['merchant_url'] = 'http://finameumain.msa-webtest1.finam.ru';

// ad: #WHO-4396
$this->paymentsProcessingSystem['dengionline']['project'] = 5791;
$this->paymentsProcessingSystem['dengionline']['source'] = 5791;
$this->paymentsProcessingSystem['dengionline']['securityKey'] = 'hJtFE8OzIg';
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXOTIC_OPTIONS][\WtConsts\PaySystems::DENGIONLINE]['project'] = 5792;
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::EXOTIC_OPTIONS][\WtConsts\PaySystems::DENGIONLINE]['source'] = 5792;

$this->paymentsProcessingSystem['qiwi']['terminal_id'] = '18286';
$this->paymentsProcessingSystem['qiwi']['password'] = '8vxhijiv';

// ad: Ukash PS - !!! TESTs on prod with TEST vouchers, given by Ukash #WTT-745
//$this->paymentsProcessingSystem['ukash']['url'] = 'https://direct.staging.ukash.com/hosted/entry.aspx';
//$this->paymentsProcessingSystem['ukash']['rppUrl'] = 'https://processing.staging.ukash.com/RPPGateway/process.asmx';
$this->paymentsProcessingSystem['ukash']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['ukash']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['ukash']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/ukash_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/ukash/
//$this->paymentsProcessingSystem['ukash']['brandId'] = 'UKASH10082';
//$this->paymentsProcessingSystem['ukash']['requestToken'] = '12345678901234567890';
//$this->paymentsProcessingSystem['ukash']['responseToken'] = 'R2345678901234567890';
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::UKASH_TEXT]['hidden'] = false;

// ad: #WTT-825
$this->paymentsProcessingSystem['netbanx']['enabled'] = true;
$this->paymentsProcessingSystem['netbanx']['currencyMap'] = array('RUB' => 'RUB', 'USD' => 'USD', 'EUR' => 'USD');
$this->paymentsProcessingSystem['netbanx']['apiKey'] = array(
    'RUB' => 'JJeSgzmPiWOFdCovFj0z:NAA6ecf50f1e7da716b6328',
    'USD' => 'JJeSgzmPiWOFdCovFj0z:NAA6ecf50f1e7da716b6328',
);
$this->paymentsProcessingSystem['netbanx']['apiUrl'] = 'https://api.test.netbanx.com/hosted/v1/orders';
$this->paymentsProcessingSystem['netbanx']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['netbanx']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['netbanx']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/netbanx_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/netbanx/
$this->paymentsProcessingSystem['netbanx']['min']['RUB'] = 0.01;

// ad: #WTI-38
$this->paymentsProcessingSystem['payuni']['gatewayId'] = 23; // dev
$this->paymentsProcessingSystem['payuni']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['payuni']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['payuni']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/payuni_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/payuni/
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_LTD]['global']['payment_systems_source'][\WtConsts\PaySystems::CHINA_UNION_PAY] = 'payuni';

// ad: #WTI-156
$this->paymentsProcessingSystem['inatec']['merchantId'] = 'gateway_test';
$this->paymentsProcessingSystem['inatec']['securityKey'] = 'b185';
$this->paymentsProcessingSystem['inatec']['api_url_sync'] = 'https://www.taurus21.com/pay/backoffice/payment_authorize';
$this->paymentsProcessingSystem['inatec']['statusUrl'] = 'https://www.taurus21.com/rep/backoffice/tx_diagnose';
$this->paymentsProcessingSystem['inatec']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/inatec_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/inatec/
$this->paymentsProcessingSystem['inatec']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['inatec']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['inatec']['return_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/generic";

// ad: #WTI-194
$this->paymentsProcessingSystem['cashu']['merchantId'] = 'whotrades';
$this->paymentsProcessingSystem['cashu']['securityKey'] = 'dfskuhr3yf';
$this->paymentsProcessingSystem['cashu']['url'] = 'https://sandbox.cashu.com/cgi-bin/pcashu.cgi';
$this->paymentsProcessingSystem['cashu']['callback'] = array(
    'url' => 'http://api.dev.whotrades.net/api/payments-processing/cashu_test/', // nginx -> http://api.ad.whotrades.net/api/payments-processing/cashu/
    'response_url' => 'https://sandbox.cashu.com/cgi-bin/notification/MerchantFeedBack.cgi',
);
$this->paymentsProcessingSystem['cashu']['merchantPrefix'] = 'wtt';
$this->paymentsProcessingSystem['cashu']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['cashu']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";
$this->paymentsProcessingSystem['cashu']['return_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/generic";
$this->paymentsProcessingSystem['merchant'][\PaymentsProcessingSystem\Recipients::WHOTRADES_SYC]['global']['hidden_payment_systems'] = array();

// ad: #WTI-138
$this->paymentsProcessingSystem['payza']['merchantId'] = 'seller_1_adubov@corp.finam.ru';
$this->paymentsProcessingSystem['payza']['securityKey'] = 'xjGLpRyQNZN11STi';
$this->paymentsProcessingSystem['payza']['url'] = 'https://sandbox.Payza.com/sandbox/payprocess.aspx';
$this->paymentsProcessingSystem['payza']['callback']['url'] = 'http://api.dev.whotrades.net/api/payments-processing/payza_test/'; // nginx -> http://api.ad.whotrades.net/api/payments-processing/payza/
$this->paymentsProcessingSystem['payza']['success_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/success";
$this->paymentsProcessingSystem['payza']['fail_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/cancel";

$this->paymentsProcessingSystem['neteller']['clientId'] = 'AAABR2LjJ7ZbJwNy';
$this->paymentsProcessingSystem['neteller']['clientSecret'] = '0.ubLvuKUYkR-Z6qykIvzkKnEMtTgfpGPLfS1O2nbwxS0.mb5CfoFarykvho7K92cjAOFtbUY';
$this->paymentsProcessingSystem['neteller']['apiUrlToken'] = 'https://test.api.neteller.com/v1/oauth2/token?grant_type=client_credentials';
$this->paymentsProcessingSystem['neteller']['apiUrlPayment'] = 'https://test.api.neteller.com/v1/transferIn';
$this->paymentsProcessingSystem['neteller']['apiUrlStatus'] = 'https://test.api.neteller.com/v1/payments/';
$this->paymentsProcessingSystem['neteller']['return_url'] = "http://whotrades.{$tld}.whotrades.net/payments/result/generic";
$this->allPaymentSystemsStaticData[\WtConsts\PaySystems::NETELLER_WALLET_TEXT]['hidden'] = false;

$this->paymentsProcessingSystem['emails_notify'] = array(
    'core' => array(
        'vdm@whotrades.org',
        'ad@whotrades.org',
        'dmsh@whotrades.org',
        'sl@whotrades.org',
    ),
    'whotrades' => array(
        // vdm: никто не получает из бизнеса whotrades уведомления от dev
    ),
    'whotrades-sh' => array(
        // vdm: никто не получает из бизнеса whotrades уведомления от dev
    ),
    'webinars' => array(
        // vdm: никто не получает из бизнеса webinars уведомления от dev
    ),
    'exotic-options' => array(
        // vdm: никто не получает из бизнеса exotic-options уведомления от dev
    ),
    'non-exchange-options' => array(
        // vdm: никто не получает из бизнеса non-exchange-options уведомления от dev
    ),
    'trade-repeater' => array(
        // vdm: никто не получает из бизнеса trade-repeater уведомления от dev
    ),
    'wt-wallet' => array(
        // vdm: никто не получает из бизнеса wt-wallet уведомления от dev
    ),
    'FL' => array(
        'fail' => array(
            // vdm: никто не получает из бизнеса FL уведомления от dev
        ),
    ),
    // ad: платежи непрошедшие или с непонятным статусом
    'status-failed-or-undefined-payments' => array(
    ),
);

$this->phpLogsSystem['crm_link'] = array(
    'trader' => "http://crm.{$dld}.whotrades.net/people/trader/",
    'person' => "http://crm.{$dld}.whotrades.net/people/"
);

$this->phpLogsSystem['json_rpc_url'] = 'http://whotrades.dev.whotrades.net/api/systems/*/rpc/php/';

$this->paymentsProcessingSystem['alwaysEnabledPaymentSystemPayerIdMap'] = array(
    // vdm: Мастербанк оставляем, хотя он итак включен для всех
    \WtConsts\PaySystems::MASTERBANK => array(
    ),
    \WtConsts\PaySystems::PAYONLINE => array(
        575232335, // Trader of Evgeny Babushkin
    ),
    \WtConsts\PaySystems::MONEYBOOKERS => array(
        575232335, // Trader of Evgeny Babushkin
    ),
    \WtConsts\PaySystems::QIWI => array(
        575232335, // Trader of Evgeny Babushkin
    )
);

//va: since #who-678
//Do we need to cache the result of sites/styles/main.tpl
$this->cacheStylesMain = false;

//sl: fardcode only for dev #WHO-926
$this->backoffice_minus_money = true;

$this->activityMarketsUrl = 'http://msa-trademng3.office.finam.ru:8003/RestService/ExecuteService';

// kz: #WHO-1167
$this->backoffice_expire_period = 60;

//warl: exotic options
$this->privateKeyPackedWtToken = 'KWJHNKJr2j35ngn3j44';

$this->externalContentLoader = array(
    'finam_news' => array(
        'sections' => array(
            1 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=1',
                        'key' => 'external_content:finam_news_section_1_page_1'
                    )
                )
            ),
            2 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=2',
                        'key' => 'external_content:finam_news_section_2_page_1'
                    )
                )
            ),
            3 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=3',
                        'key' => 'external_content:finam_news_section_3_page_1'
                    )
                )
            ),
            4 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=4',
                        'key' => 'external_content:finam_news_section_4_page_1'
                    )
                )
            ),
            5 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=5',
                        'key' => 'external_content:finam_news_section_5_page_1'
                    )
                )
            ),
            6 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=6',
                        'key' => 'external_content:finam_news_section_6_page_1'
                    )
                )
            ),
            7 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://stage.finam.ru/service.asp?name=news-belt&action=page&page=1&section=7',
                        'key' => 'external_content:finam_news_section_7_page_1'
                    )
                )
            ),
        ),
        'content_type' => 'html',

        'charset' => array(
            'from' => 'CP1251', 'to' => 'UTF-8'
        )
    ),

    'webinar' => array(
        'sections' => array(
            1 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://rel.finam.ru/rss/RSS_webinar.asp?n=1',
                        'key' => 'external_content:webinar_section_1_page_1'
                    )
                )
            ),
        ),
        'content_type' => 'rss'
    )
);

$this->finamru_location = 'http://stage.finam.ru/';

// iv: #WHO-4234
$this->externalContentUtmProxiedHosts = array(
    'www.finam.ru',
    'stage.finam.ru',
    'finam.fm',
    'bonds.finam.ru'
);

$this->enableLanguageDetectionApi = false;

// btp-daemon settings
$this->monitoring['daemon']['enabled'] = true; //mk: temporary disabled

// mongodb storage settings
$this->monitoring['storage']['enabled'] = true; //mk: temporary disabled

$this->clientAssistance['emails_notify']['cash_out'] = array(
    'warl@whotrades.net'
);

$this->integration_finamru_salt = 'skh3i(!oh39gn4902k2';

$this->finamTenderSystem['account_counts'] = array(
    'xetra'=>array(
        'error'=>300,
        'normal'=>500,
        'key'=>'pool_available_accounts_xetra_10000',
    ),
    'forex'=>array(
        'error'=>300,
        'normal'=>500,
        'key'=>'pool_available_accounts_forex_10000',
    ),
    'nysdaq'=>array(
        'error'=>300,
        'normal'=>500,
        'key'=>'pool_available_accounts_nysdaq_10000',
    ),
    'mct'=>array(
        'error'=>300,
        'normal'=>500,
        'key'=>'pool_available_accounts_mct_10000',
    )
);

$this->wt_yandex_metrika_id = false;

$this->clientAssistance['exclude_group_ids'] = array(
    30757330841
);

$this->returning_email_duration_after_registration = 5*60;
$this->returning_email_duration_after_confirmation = 5*60;

$this->geoIpSystem['db']['location'] =
// ad: GeoIp since #WHO-4560
$this->phpLogsSystem['geoip']['db']['location'] =
// ad: GeoIp since #WTI-156
$this->paymentsProcessingSystem['geoip']['db']['location'] =
        '/home/' . $dld . '/dev/services/geo2ip-data/GeoLiteCity.dat';

$this->notificationSystem['popularAuthors'] = array(634278825);

// ad: maintain payments systems config in sync with non-prod overrides
$this->paymentsProcessingSystem['allPaymentSystemsStaticData'] = $this->allPaymentSystemsStaticData;

$this->shortLinkSystem['domain'] = "sls.{$dld}.whotrades.net";
$this->shortLinkSystem['domainGo'] = "whotrades.{$dld}.whotrades.net/go";
$this->shortLinkSystem['fallbackUrl'] = "http://whotrades.{$dld}.whotrades.net";

$this->dictionaryCache = array(
    'enabled' => false,
    'path'    => '/tmp/Dictionary',
);

$this->cdn['stat_url'] = '//stat-cdn.dev.whotrades.net/v1/cdn/pixel';

// dz: #WTT-1024 - list 'lang' => 'blog_group_id'
$this->serviceAboutLtd = array(
    'allowedGroup' => array(
        'th' => 500941052,
        'es' => 839039587,
        'en' => 456318740,
        'zh' => 220250367,
        'ar' => 124972003,
        'ru' => 30586258589,
    ),
);

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!