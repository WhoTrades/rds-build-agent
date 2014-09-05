<?php
/**
 * Это файл с переопределением конфигруации для тестового контура и который должен подключаться вместо config.dev в тестовой среде (tst)
 **/
require_once dirname(__FILE__) . '/env-preprod.php';

// vdm: делаем после подключение env-preprod, т.к. в нем эта переменная использоваться не должна
if (!isset($tld)) {
    $tld = 'tst';
}

require_once __DIR__ . '/config.enterprisesystem.tst.php';
// vdm: HACK: надо будет избавиться от этого кода
require_once dirname(__FILE__) . '/config.dev.comon.php';

$this->ssl['enabled'] = true;

// vdm: все идет после config.dev.comon.php чтобы переопределять dev -> tst
$this->group_thai_edu_group_id = 30699311481;
$this->group_china_edu_group_id = 30476238632;
$this->group_china_eng_edu_group_id = 30714622763;
$this->group_usa_president_elections_2012_group_id = 30429775156;
$this->group_exotic_options_group_id = 30757330841;
$this->group_usa_group_id = 30970629529;
$this->group_mma_group_id = 30733304658;
$this->group_partners_group_id = 30748615940;

$this->css_merged = false;
$this->javascript_merged = false;

/**
 * Config to work at @dev
 */

$this->DEBUG_MODE = 1;

$this->debug_show_hacker_console_ip_list = array(
    '192.168.78.76', // iv
    '78.41.194.83',  // Finam office
    '192.168.136.2', // 436 vlan
    '192.168.78.189', // vdm
    '192.168.136.226', // vdm
    '192.168.14.4',  // di
    '192.168.136.227', // gateway
    '192.168.14.5',  // di2 (sometimes)
    '192.168.136.9',  // ag IP
);

$this->JSON_DEBUG_MODE = 1;
$this->debug_dictionary_show_hash = 1;
//$this->debug_php53 = 1;
$this->stat_mode = 2; // 2

$this->API_DEBUG_MODE = 1;

$this->api_tokens = array(
    'test'=>'secret'
);

$this->person_id_for_referrals_from_banner = 571251974;

// No assert checks when profiling and no performance stat
if (@$_GET['XDEBUG_PROFILE']) {
    $this->DEBUG_MODE = 0;
    $this->DEBUG_ASSERT = 0;
    $this->stat_mode = 0;
}

ini_set('xdebug.collect_params', 3);
ini_set('xdebug.dump_undefined', 1);

$this->geo_earth_object_id = 60329637671;

$this->rmin_of_top_videos = 1;

$this->videoroom_location = 'rtmp://192.168.15.120/live/publishlive/';

// vdm: new qotas
$this->quota['groups_create']['overall']['limit'] = 200;
$this->quota['groups_join']['overall']['limit'] = 1000;

// vdm: new activity is enabled at .dev
$this->activitySystem['enabled'] = true;
$this->activitySystem['cometServer']['namespace'] = null;
// vdm: it is required to allow work with .vdm/.vik/.bash
unset($this->activitySystem['cometServer']['location']);

//for facebook authentication
$this->facebook['api']['applicationId'] = '131951393524144';
$this->facebook['api']['applicationSecret'] = 'e6413484817697f57124dff1e2e03c2b';


$this->staticImagesLocationUrl = "http://static.{$dld}.whotrades.net"; // al: don't need a "/" in the end
$this->jsLocationUrl = "http://static.{$dld}.whotrades.net/";
$this->cssLocationUrl = "http://static.{$dld}.whotrades.net/";
$this->staticDir = "http://static.{$dld}.whotrades.net"; // al: don't need a "/" in the end

// bash: need different logins at dev and prod
$this->twitterSystem['twitterCom']['api_stream_user'] = 'bash4444';
//$Config->twitterSystem['twitter_com']['api_stream_password'] is the same

$this->remote_dictionaries = array(
    'mirtesen.ru' => array(
        'host' => 'mdr.mirtesen.prod',
        'httpAuthentication' => array(
            'login' => 'sys@none',
            'password' => 'g55jTWqt',
        ),
    ),
    'whotrades.com' => array(
        'host' => 'mdr.whotrades.com',
    )
);

$this->comments_count_limit = 50;


// ir: Время когда слушба поддержки не работает
$this->manages_not_working_period = array(
    // ir: с пятницы 5pm
    'startDay'  => 5, //friday
    'startHour'  => 17, // 5pm
    // ir: до воскресенья 5pm
    'endDay'    => 7, //sunday
    'endHour'    => 17, //5pm
);



// vdm: no such options at .dev
unset($this->mailing_options);

$this->allowed_users = array('apache');

$this->lock_dir = '/var/tmp/mirtesen';


$this->exoticOptionsJsLocationUrl = 'https://fttest.finam.ru/wbo-dev/whobetson.js';

// yandex map apy key
$this->ymap_api_key = "ANzPU00BAAAA1ZDyGQIACx9yXki80M1NVdE8be-3VSPekx8AAAAAAAAAAAD65W-yBKqTo7283F-7Cc3N-FaBwg==";

$this->finamru_location = 'http://rel.finam.ru/';
$this->integration_finamru_salt = 'Akn49J12k5o9KDSKL2-3kjg0044n!@32';

$this->use_strict_tag_filter = true;

//vik: salt for integration with comon.ru
$this->comonru_location = 'http://WEBCOMONTEST.finam.ru/';

$this->server_learn_location = "http://learning.whotrades.{$dld}.whotrades.net/";

$this->integration_comonru_salt = 'dfHrt38Lsker';
$this->integration_comonru_url = $this->comonru_location . 'login/external/social/';

$this->personAuthLearningSalt = 'Qe33kMNKS2km533';

$this->blog_post_notification['awm_optimization_on_for_site_larger_than'] = 5;

//TODO lk: can we use this support manager pool in dev-mode?
$this->support_person_obj_ids['en'] = array(874861594, 813086836);
$this->support_person_obj_ids['th'] = array();
$this->support_person_obj_ids['zh'] = array();

//id: WHO-2003: controls exception throwing on unacceptable urls:
$this->urlMapThrowExceptions = true;
$this->external_lib_dir = dirname(__FILE__) . '/../../lib/';

$this->developers_only_mail_filter_forbidden_receiver = "forbidden+tst@whotrades.org";

//bn: configuration for techical notifications
$this->mailingSystem['technical']['trouble_email'] = 'test-php@whotrades.net'; 	// email for report trouble form
$this->mailingSystem['technical']['form_email']	= 'test-php@whotrades.net';		// email for feedback form
$this->mailingSystem['technical']['wrong_phone_email']	= 'test-php@whotrades.net';		// email for wrong phone form

// ad: old (test) cabinet section #WHO-3799
$this->old_cabinet_location = 'http://wt.msa-tstcabweb.office.finam.ru/';

$this->CmdSystem['api']['url'] = "http://cmd.{$dld}.whotrades.net/json-rpc.php";
$this->CmdSystem['api']['routeToModerationUnitUrl'] = "http://cmd.{$dld}.whotrades.net/index/route-to-moderation-unit/external-id/";

// lk: redis db config
$this->redis['server']['durable']['host'] = 'rs-0-1.comon.local'; // TODO: move redis from devap
$this->redis['server']['durable']['port'] = 6379;
$this->redis['server']['fast']['port'] = 6379;

//
$this->CrmSystem['api']['url'] = "http://crm.{$dld}.whotrades.net/json-rpc.php";

// ag: Remove realAccountQuestionnaireVersion. Since #WTT-188

// bn: @since #WTT-63
$this->EnterpriseService['notificationGroups']['tradeRepeater'] = array(); // не шлем нотификацию для этой группы на дев-контуре
//lk: since #WTT-702
$this->EnterpriseService['notificationGroups']['backOffice'] = array(); // не спамим для этой группы на tst+dev

$this->EnterpriseService['notificationGroups']['backOfficeSupport'] = array('agorlanov@corp.finam.ru');

$this->mailingSystem['application_exception_notify']['core'] = array('oops@whotrades.org');
$this->mailingSystem['application_exception_notify']['go2trade'] = array('oops@whotrades.org');

$this->shortLinkSystem['domain'] = "sls.{$tld}.whotrades.net";

$this->geoIpSystem['db']['location'] =
// ad: GeoIp since #WHO-4560
$this->phpLogsSystem['geoip']['db']['location'] =
// ad: GeoIp since #WTI-156
$this->paymentsProcessingSystem['geoip']['db']['location'] =
        '/home/dev/dev/services/geo2ip-data/GeoLiteCity.dat';

$this->use_styles_cache = true;
$this->less_binary = '/usr/bin/strace -f -e trace=file -o {{strace_out_file}} /var/opt/node_modules/less/bin/lessc';
$this->stylus_binary = '/usr/bin/strace -f -e trace=file -o {{strace_out_file}} /usr/bin/stylus';
$this->assets_cache_dir = '/tmp/assets_cache/'.$dld.'/';


$this->phpLogsSystem['service']['location'] = "http://phplogs.{$tld}.whotrades.net/api/";
$this->phpLogsSystem['users'] = array(
    'warl' => '1234567890',
    'vdm'  => '1234567890',
    'sl'   => '1234567890',
    'dmsh' => '1234567890',
    'lk'   => '1234567890',
    'kz'   => '1234567890',
    'va'   => '1234567890',
    'az'   => '789456',
    'an'   => '123',
    'money' => 'money',
    'vs' => '123'
);
$this->phpLogsSystem['users_roles'] = array(
    //'az' => 'payments_processing_recipient_whotrades'
);

// vdm: важно что тут этот адрес, т.к. ssl сертификат выдан на *.finam.ru, а адрес msa-ft-test.office.finam.ru уже не подходит
$this->tradeWidget['location']['script'] = '//ft-test.finam.ru/tradewidget/tradewidget.js';
// vdm: этот адрес доступен только из локальной сети и специально прописан он, т.к. на это заложена логика выдачи прав. Важно что http, потому что на https сервис не отвечает
$this->tradeWidget['location']['server'] = 'http://msa-ft-test.office.finam.ru/ft/test/preprod';

// dz: аккаунты которые показываются в торговалке для гостей @since #WTT-1472
$this->tradeWidget['guest'] = array(
    'showAccounts' => array(
        array(
            'login'        => 'twA1/106307',
            'password'     => '42c77d1122',
            'market'       => 'mct',
            'traderSystem' => 'TDMMA1',
        ),
    )
);

// lk: ETNA separated uat-server for tst. #WTI-178, #WTI-222
$this->tradePlatforms['whotrades_plus']['url']['demo'] = 'http://papertrading.etna.uat.whotrades.net/User/LogOnByToken';

//tt #WTS-822 for test
$this->chatSystem['balls_count_for_ban'] = 3;

$this->cdn['use_cdn'] = false;
$this->cdn['use_host_without_cookie'] = false;

$this->chooseMasterClassRedirectTo = "http://whotrades.$dld.whotrades.net/landing/masterclass";

$this->mirrorDomains = array("china-test.$dld.whotrades.net" => "whotrades.$dld.whotrades.net");

$this->socialImport['wordpress'] = array(
    'client_id' => 35893,
    'client_secret' => 'U74iahZdcMW2TgRqiqD9fCuZd3fou6cC7g38cq7tm2vbhoCyRIlaM9rSy4FZnjH5'
);

$this->stockTwits['groupMap'] = [
    30469835084 => [
        'login' => 'ents',
        'password' => 'hello34',
    ],
];

$this->finamTenderSystem['useFakeSoniqMq'] = false;

//http://msk-ft-prep1/JT/server_debug

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!