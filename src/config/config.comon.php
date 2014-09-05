<?php
/**
 * Настройки для проекта whotrades.com aka comon. Должен подключаться из конфигурационных env-файлов уровня prod
 */
$this->project = 'comon';

$this->serverName = @$this->HTTP_HOST? $this->HTTP_HOST : 'whotrades.com';
//

$this->login_secret = 'asd12asd12kd-=ASD3#@Sasd';

$this->main_domain = "whotrades.com";

$this->base_domains = explode(" ", "console www.core.local" /* vdm: NB: ask me before add here anything!!! */);

$this->API_DEBUG_MODE = 0;


//@todo: запонить токены для приложений
$this->api_tokens = array(
    'test'=>'secretdassasdasasasdasasddas123123123asd314adae1'
);



if (isset($this->url_scheme)) {
    $this->urlServer = sprintf("%s://%s%s", $this->url_scheme, $this->serverName, @$this->SERVER_PORT ? ($this->SERVER_PORT != 80 ? ":{$this->SERVER_PORT}" : "") : "");
    $this->currentUrl = $this->urlServer . (!empty($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '');
}

// vdm: we need this for mdr.whotrades.com, mdr.wtpred.net
if (isset($this->mode) && $this->mode== 'mdr') {
    $this->base_domains[] = "whotrades.com";
    $this->base_domains[] = "wtpred.net";
}
//$this->base_domains[] = "whotrades.com";
//$this->base_domains[] = "facebook.whotrades.com";

$this->http_header_custom = "X-WhoTrades";
$this->http_header_background = "X-WhoTrades-Background";

$this->session_name = "whotrades";

if (isset($this->mode) && !in_array($this->mode, array('mdr'))) {
    $this->mode = 'group';
    $this->fatalControllerLocation = 'nginx/comon/fatal.html';
}

// vdm: подключаем только для основного проекта
if (isset($this->platforma_dir)) {
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMap.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapMessages.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapComonRu.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapExoticOptions.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapBlogs.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapCharts.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapCabinet.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapInstruments.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapServices.php';
    $this->urlMapLocations[] = $this->platforma_dir . 'urlMapWhotradesUsa.php';
}

//id: WHO-2003: controls exception throwing on unacceptable urls:
$this->urlMapThrowExceptions = false;

// vmd: ssl is temporary disabled
$this->ssl['enabled'] = true;

// vdm: no captcha by NS's request
// inal' kyatov: values: off | auto | force
$this->captcha_on_login = 'off';
$this->captcha_on_password = 'off';
$this->captcha_on_registration = 'off';
$this->captcha_on_create_group = 'off';
$this->captcha_on_write_message = 'off';
$this->captcha_on_join_group = 'off';
$this->captcha_on_newsletter = 'off';

$this->bad_day_limit = 30;
$this->profit_interval = '1 month';
$this->group_platforma_group_id = $this->group_id = 30892291396;
$this->group_exotic_options_group_id = 30101786698;
$this->group_guru_group_id = 30726130659;

$this->group_algo_trading_group_id = 30651403960;
$this->group_finam_group_id = 30166161618;
$this->group_usa_group_id = 30133661355;
$this->group_partners_group_id = 30404786570;

// dz: #WTT-1146
$this->group_contest_indian_olympic_group_id = 30301507839;

// vdm: no such options in whotrades
unset($this->mailing_options);

//sl: create group is free
$this->group_create_is_free = true;

$this->group_domain_name_3rd_level_to_2nd_level = true;

$this->translateMode = 0;

//vik: VERY IMPORTANT!!! for hidden mention about mirtesen.ru, de bene esse
$this->facebook['api']['applicationId'] = null;
$this->facebook['api']['applicationSecret'] = null;

$this->facebook['default_settings_group_id'] = $this->group_platforma_group_id;
$this->facebook['default_settings_domain_list'] = array('whotrades.com');

$this->qqComSystem['verification'] = '14073570404214536375';
$this->qqComSystem['api']['appId'] = '100282012';
$this->qqComSystem['api']['key'] = '88c50ab16b3d4bd209599ee816785589';
$this->qqComSystem['api']['redirectUrl'] = 'http://whotrades.com/from-qq-com';

// vk.com
$this->vkontakte['whotrades_com']['applicationId']     = 3152711;
$this->vkontakte['whotrades_com']['applicationSecret'] = 'k1vxjrtpotBmlGazTI7w';

$this->vkontakteEnv = 'whotrades_com'; // va: currently used environment for vkontakte

$this->cometServer['host'] = 'cmt.comon.local';
$this->cometServer['port'] = 10010;
$this->cometServer['path'] = '/';
$this->cometServer['alias'] = 99;
$this->cometServer['personal_channel_salt'] = 'Kajrnk292kk590)O!KJ@Kt5nn66kl3';

$this->activitySystem['cometServer']['host'] = 'cmt.comon.local';
$this->activitySystem['cometServer']['port'] = 10010;
$this->activitySystem['cometServer']['path'] = '/';
$this->activitySystem['cometServer']['alias'] = 99;

$this->sphinxServer['location'] = 'spx-0-1.comon.local';
$this->sphinxServer['port'] = 3312;

$this->enable_russians = true;

$this->fakePromoPeopleOnMain = array(
	// thai
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 899,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 1442,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 1558,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 1680,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 888,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-6.jpg',
        'gender' => 'male',
        'moneyValue' => 1273,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-7.jpg',
        'gender' => 'male',
        'moneyValue' => 509,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-8.jpg',
        'gender' => 'male',
        'moneyValue' => 758,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-9.jpg',
        'gender' => 'male',
        'moneyValue' => 964,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-man-10.jpg',
        'gender' => 'male',
        'moneyValue' => 768,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 991,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 519,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 1685,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 1649,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 640,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 732,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 1107,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 728,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-9.jpg',
        'gender' => 'female',
        'moneyValue' => 1239,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'th',
        'picSrc' => '/site/blocks/promo-people-on-main/images/thai-woman-10.jpg',
        'gender' => 'female',
        'moneyValue' => 1450,
        'currency' => 'USD',
    ),

	// china
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 1741,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 632,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 1370,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 816,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 1622,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-6.jpg',
        'gender' => 'male',
        'moneyValue' => 1169,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-7.jpg',
        'gender' => 'male',
        'moneyValue' => 660,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-8.jpg',
        'gender' => 'male',
        'moneyValue' => 999,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-9.jpg',
        'gender' => 'male',
        'moneyValue' => 1283,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-man-10.jpg',
        'gender' => 'male',
        'moneyValue' => 1310,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 535,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 1124,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 1418,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 797,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 957,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1066,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 687,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 999,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-9.jpg',
        'gender' => 'female',
        'moneyValue' => 865,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'zh',
        'picSrc' => '/site/blocks/promo-people-on-main/images/china-woman-10.jpg',
        'gender' => 'female',
        'moneyValue' => 1207,
        'currency' => 'USD',
    ),

	// indian
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 548,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 1176,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 1267,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 942,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 1245,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-6.jpg',
        'gender' => 'male',
        'moneyValue' => 1015,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-7.jpg',
        'gender' => 'male',
        'moneyValue' => 1513,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-8.jpg',
        'gender' => 'male',
        'moneyValue' => 1051,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-9.jpg',
        'gender' => 'male',
        'moneyValue' => 1368,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-man-10.jpg',
        'gender' => 'male',
        'moneyValue' => 1748,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 1302,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 1748,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 857,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 1295,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 947,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1299,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 1392,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 1526,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-9.jpg',
        'gender' => 'female',
        'moneyValue' => 1565,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hi',
        'picSrc' => '/site/blocks/promo-people-on-main/images/indian-woman-10.jpg',
        'gender' => 'female',
        'moneyValue' => 501,
        'currency' => 'USD',
    ),

	// spanish
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 558,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 1876,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 167,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 342,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 1455,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-6.jpg',
        'gender' => 'male',
        'moneyValue' => 1125,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-7.jpg',
        'gender' => 'male',
        'moneyValue' => 1138,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-8.jpg',
        'gender' => 'male',
        'moneyValue' => 1854,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-9.jpg',
        'gender' => 'male',
        'moneyValue' => 1318,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-10.jpg',
        'gender' => 'male',
        'moneyValue' => 1138,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 1502,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 1948,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 757,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 2295,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 347,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1300,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 192,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'es',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 1126,
        'currency' => 'USD',
    ),

    // vdm: решили что испанцы прокатят вместо португальцев
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 558,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 1876,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 167,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 342,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 1455,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-6.jpg',
        'gender' => 'male',
        'moneyValue' => 1125,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-7.jpg',
        'gender' => 'male',
        'moneyValue' => 1138,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-8.jpg',
        'gender' => 'male',
        'moneyValue' => 1854,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-9.jpg',
        'gender' => 'male',
        'moneyValue' => 1318,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-man-10.jpg',
        'gender' => 'male',
        'moneyValue' => 1138,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 1502,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 1948,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 757,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 2295,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 347,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1300,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 192,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/spanish-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 1126,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/african-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 192,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'pt',
        'picSrc' => '/site/blocks/promo-people-on-main/images/african-man-1.jpg',
        'gender' => 'female',
        'moneyValue' => 1126,
        'currency' => 'USD',
    ),

    // hungary
	array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 158,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 871,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 1267,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 1342,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 455,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 502,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 948,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 557,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 295,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'hu',
        'picSrc' => '/site/blocks/promo-people-on-main/images/hungary-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 247,
        'currency' => 'EUR',
    ),

    // french
	array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-man-1.jpg',
        'gender' => 'male',
        'moneyValue' => 158,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-man-2.jpg',
        'gender' => 'male',
        'moneyValue' => 871,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-man-3.jpg',
        'gender' => 'male',
        'moneyValue' => 1267,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-man-4.jpg',
        'gender' => 'male',
        'moneyValue' => 1342,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-man-5.jpg',
        'gender' => 'male',
        'moneyValue' => 455,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-woman-1.jpg',
        'gender' => 'female',
        'moneyValue' => 502,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 948,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-woman-3.jpg',
        'gender' => 'female',
        'moneyValue' => 557,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 295,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/europe-french-speaking-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 247,
        'currency' => 'EUR',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/african-woman-2.jpg',
        'gender' => 'female',
        'moneyValue' => 192,
        'currency' => 'USD',
    ),
    array(
        'lcid' => 'fr',
        'picSrc' => '/site/blocks/promo-people-on-main/images/african-man-2.jpg',
        'gender' => 'female',
        'moneyValue' => 1126,
        'currency' => 'USD',
    ),

	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-man-1.jpg',
		'gender' => 'male',
		'moneyValue' => 2522,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-man-2.jpg',
		'gender' => 'male',
		'moneyValue' => 2842,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-man-3.jpg',
		'gender' => 'male',
		'moneyValue' => 2678,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-man-4.jpg',
		'gender' => 'male',
		'moneyValue' => 1687,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-man-5.jpg',
		'gender' => 'male',
		'moneyValue' => 2020,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-woman-1.jpg',
		'gender' => 'female',
		'moneyValue' => 2560,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-woman-2.jpg',
		'gender' => 'female',
		'moneyValue' => 2430,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-woman-3.jpg',
		'gender' => 'female',
		'moneyValue' => 1865,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-woman-4.jpg',
		'gender' => 'female',
		'moneyValue' => 2680,
		'currency' => 'USD',
	),
	array(
		'lcid' => 'ar',
		'picSrc' => '/site/blocks/promo-people-on-main/images/arabic-woman-5.jpg',
		'gender' => 'female',
		'moneyValue' => 1486,
		'currency' => 'USD',
	),


    // other
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-3.jpg',
        'gender' => 'female',
        'moneyValue' => 986,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-4.jpg',
        'gender' => 'female',
        'moneyValue' => 713,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-5.jpg',
        'gender' => 'female',
        'moneyValue' => 515,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1338,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-7.jpg',
        'gender' => 'female',
        'moneyValue' => 1178,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-8.jpg',
        'gender' => 'female',
        'moneyValue' => 2493,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-9.jpg',
        'gender' => 'female',
        'moneyValue' => 1888,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-10.jpg',
        'gender' => 'female',
        'moneyValue' => 956,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-11.jpg',
        'gender' => 'female',
        'moneyValue' => 1677,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-12.jpg',
        'gender' => 'female',
        'moneyValue' => 2066,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-13.jpg',
        'gender' => 'female',
        'moneyValue' => 946,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-14.jpg',
        'gender' => 'female',
        'moneyValue' => 1461,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-15.jpg',
        'gender' => 'female',
        'moneyValue' => 2642,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-16.jpg',
        'gender' => 'female',
        'moneyValue' => 642,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-17.jpg',
        'gender' => 'female',
        'moneyValue' => 1296,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-18.jpg',
        'gender' => 'female',
        'moneyValue' => 942,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-man-19.jpg',
        'gender' => 'female',
        'moneyValue' => 1743,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-4.jpg',
        'gender' => 'female',
        'moneyValue' => 2120,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-5.jpg',
        'gender' => 'female',
        'moneyValue' => 1756,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-6.jpg',
        'gender' => 'female',
        'moneyValue' => 1290,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-7.jpg',
        'gender' => 'female',
        'moneyValue' => 2888,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-8.jpg',
        'gender' => 'female',
        'moneyValue' => 971,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-9.jpg',
        'gender' => 'female',
        'moneyValue' => 1695,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-10.jpg',
        'gender' => 'female',
        'moneyValue' => 2107,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-11.jpg',
        'gender' => 'female',
        'moneyValue' => 1063,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-12.jpg',
        'gender' => 'female',
        'moneyValue' => 1633,
        'currency' => 'USD',
    ),
    array(
        'picSrc' => '/site/blocks/promo-people-on-main/images/other-woman-13.jpg',
        'gender' => 'female',
        'moneyValue' => 2331,
        'currency' => 'USD',
    ),
);

// vdm: можно будет это убить
$this->usa_president_elections_2012_is_enable = false;
$this->usa_president_elections_2012_posts = array(
    "ru" => "http://news-ru.whotrades.com/blog/43978573979",
    "ar" => "http://news-ar.whotrades.com/blog/43755501130",
    "en" => "http://news.whotrades.com/blog/43632481244",
    "zh" => "http://news-zh.whotrades.com/blog/43078626942",
    "th" => "http://news-th.whotrades.com/blog/43855554093",
);

$this->image_blank_male           = '/images/comon/blank_male.gif';
$this->image_blank_male_normal    = '/images/comon/blank_male.gif';
$this->image_blank_male_medium    = '/images/comon/blank_male.gif';		  // 120 x 120
$this->image_blank_male_xmedium   = '/images/comon/blank_male_xmedium.gif'; // 74 x 74
$this->image_blank_male_main      = '/images/comon/blank_male_main.gif'; 	  // 200 x 120
$this->image_blank_male_small     = '/images/comon/blank_male_med.gif';     // 48 x 48
$this->image_blank_male_xsmall    = '/images/comon/blank_male_small.gif';   // 24 x 24

$this->image_blank_female         = '/images/comon/blank_female.gif';
$this->image_blank_female_normal  = '/images/comon/blank_female.gif';
$this->image_blank_female_medium  = '/images/comon/blank_female.gif';
$this->image_blank_female_xmedium = '/images/comon/blank_female_xmedium.gif';
$this->image_blank_female_main    = '/images/comon/blank_female_main.gif';
$this->image_blank_female_small   = '/images/comon/blank_female_med.gif';
$this->image_blank_female_xsmall  = '/images/comon/blank_female_small.gif';

$this->uploadLocationUrl = 'http://upload.whotrades.com/';
$this->bfsSystem['servers'] = array('get.whotrades.com');

$this->imageServers = array('get1.whotrades.com', 'get2.whotrades.com', 'get3.whotrades.com', 'get4.whotrades.com');

$this->dns_alias_host_name = null;
$this->developers_person_obj_ids[] = 15311282; // vodmal@yandex.ru
$this->developers_person_obj_ids[] = 661033276; // whotrades.com@gmail.com
$this->developers_person_obj_ids[] = 576821225; // dmsh@nasvete.ru
$this->developers_person_obj_ids[] = 976503447; // dmsh9@nasvete.ru
$this->developers_person_obj_ids[] = 167894472; // Dmitry Trost
$this->developers_person_obj_ids[] = 384370940; // Dmitry Grishin
$this->developers_person_obj_ids[] = 931773706; // Marat Raykhel
$this->developers_person_obj_ids[] = 407303971; // Anton Zhukov
$this->developers_person_obj_ids[] = 259232534; // Pavel Lvov (Carleta Meyer)
$this->developers_person_obj_ids[] = 475179372; // Eugeny Babushkin
$this->developers_person_obj_ids[] = 789078273; // Александр Лобашев
$this->developers_person_obj_ids[] = 625371972; // Афанасьев Антон
$this->developers_person_obj_ids[] = 51054052;  // Даутов Салават

$this->developers_person_obj_ids[] = 651788745; // Kristina Lazebnik
$this->developers_person_obj_ids[] = 389908061; // Masha Maria (whotrades@list.ru) - #15002 - $78.05
$this->developers_person_obj_ids[] = 951418004; // Joe Tribiani (zhilin.e@me.com) - #15393 - $8.90
$this->developers_person_obj_ids[] = 366411508; // Lana Lana (whotr@mail.ru)  - #16198 - $100
$this->developers_person_obj_ids[] = 374067149; // Sheldon Sidney (lazebnik@finam.eu) - #16360 - $100
$this->developers_person_obj_ids[] = 659974016; // Vladislav Kochetkov kochetkovv@mail.ru
$this->developers_person_obj_ids[] = 80360677;  // Ilya ilya (whotrades_3@mail.ru) - #20149
$this->developers_person_obj_ids[] = 682749868; // Praveen Kumar  (1kumar.praveen1@gmail.com ) #25856
$this->developers_person_obj_ids[] = 351968415; // Navneet Bhatia  (navneet.bhatia0@gmail.com )  #25857
$this->developers_person_obj_ids[] = 21186962;  // Gauri Mehta (gaurimehta40@yahoo.com )   #25858
$this->developers_person_obj_ids[] = 467332660; // Jyoti Patel (patel.jyoti@mail.com)   #25859

$this->developers_person_obj_ids[] = 712504243; // Арсен Айвазов
$this->developers_person_obj_ids[] = 803334700; // Артем Моисеев
$this->developers_person_obj_ids[] = 668642691; // богданов
$this->developers_person_obj_ids[] = 691609614; // ashponko
$this->developers_person_obj_ids[] = 293765032; // Gorin
$this->developers_person_obj_ids[] = 784006936; // Прохоров
$this->developers_person_obj_ids[] = 919206550; // Трость
$this->developers_person_obj_ids[] = 214091164; // Трость
$this->developers_person_obj_ids[] = 213608641; // rmukhin@corp.finam.ru
$this->developers_person_obj_ids[] = 328662933; // Долженков
$this->developers_person_obj_ids[] = 391980355; // Колганихина
$this->developers_person_obj_ids[] = 514921885; // Нина Тарасова
$this->developers_person_obj_ids[] = 529420895; // Дмитрий Ерзунов
$this->developers_person_obj_ids[] = 519139543; // dmsh+china_bj@whotrades.net

$this->developers_person_obj_ids[] = 473014626;
$this->developers_person_obj_ids[] = 919160324;
$this->developers_person_obj_ids[] = 142233173;
$this->developers_person_obj_ids[] = 365306022;
$this->developers_person_obj_ids[] = 588378871;
$this->developers_person_obj_ids[] = 257597418;
$this->developers_person_obj_ids[] = 480670267;
$this->developers_person_obj_ids[] = 926815965;
$this->developers_person_obj_ids[] = 149888814;
$this->developers_person_obj_ids[] = 819107361;
$this->developers_person_obj_ids[] = 42180210;
$this->developers_person_obj_ids[] = 934471606;
$this->developers_person_obj_ids[] = 488325908;
$this->developers_person_obj_ids[] = 157544455;
$this->developers_person_obj_ids[] = 826763002;
$this->developers_person_obj_ids[] = 942127247;
$this->developers_person_obj_ids[] = 272908700;
$this->developers_person_obj_ids[] = 495981549;
$this->developers_person_obj_ids[] = 834418643;
$this->developers_person_obj_ids[] = 280564341;

// since 2012-08-30 by Bina's request
$this->developers_person_obj_ids[] = 750301687;
$this->developers_person_obj_ids[] = 633059743;
$this->developers_person_obj_ids[] = 894170857;
$this->developers_person_obj_ids[] = 445809782;
$this->developers_person_obj_ids[] = 569310429;
$this->developers_person_obj_ids[] = 839039587;
$this->developers_person_obj_ids[] = 921565891;

// since 2012-08-31 by Marat's request
$this->developers_person_obj_ids[] = 500941052;
$this->developers_person_obj_ids[] = 623960938;

// since 2012-09-03 by Zhilin's request
$this->developers_person_obj_ids[] = 553471279; // Trip - Ballermax : 26428 FOREX
$this->developers_person_obj_ids[] = 730610282;  // Mehul - Fatboy: 26421 FOREX
$this->developers_person_obj_ids[] = 413887137; // Adam - 26406 FOREX

// since 2012-10-02 by Dmsh's request
$this->developers_person_obj_ids[] = 442536907; // dmsh+2012-10-02_1rf@whotrades.net
$this->developers_person_obj_ids[] = 665609756; // dmsh+2012-10-02_2rf@whotrades.net
$this->developers_person_obj_ids[] = 888682605; // dmsh+2012-10-02_3rf@whotrades.net
$this->developers_person_obj_ids[] = 111755454; // dmsh+2012-10-02_4rf@whotrades.net
$this->developers_person_obj_ids[] = 334828303; // forex@joelalcala.net
$this->developers_person_obj_ids[] = 435025230; // testdaria
$this->developers_person_obj_ids[] = 676683998; // testdariaF
$this->developers_person_obj_ids[] = 15121092; // testdariaD
$this->developers_person_obj_ids[] = 361213827; // testdariaK

// since 2012-10-10 by Dmsh's request
$this->developers_person_obj_ids[] = 407147673; // EuropeSR EuropeSR
$this->developers_person_obj_ids[] = 76366220; // AmericaSR AmericaSR

// since 2012-12-11 by Zhilin's request
$this->developers_person_obj_ids[] = 351066334; // Adam

// since 2013-04-09 17:06 by dkolganikhina
$this->developers_person_obj_ids[] = 934616451; // WhoTrades Chatter

//since #WHO-2042
$this->developers_person_obj_ids[] = 105262978;
$this->developers_person_obj_ids[] = 434889195;
$this->developers_person_obj_ids[] = 173008511;
$this->developers_person_obj_ids[] = 488091254;
$this->developers_person_obj_ids[] = 759646599;

// Adam's custom sites built on blogs
$this->developers_person_obj_ids[] = 240669521;
$this->developers_person_obj_ids[] = 356033766;

//since #WHO-4385
$this->developers_person_obj_ids[] = 74799355;
$this->developers_person_obj_ids[] = 320839127;

//an: для Павлюк Олеси
$this->developers_person_obj_ids[] = 929733128;

//warl: forecast writers from varvara
$this->developers_person_obj_ids[] = 11394767;
$this->developers_person_obj_ids[] = 513151615;
$this->developers_person_obj_ids[] = 277319658;
$this->developers_person_obj_ids[] = 116599185;
$this->developers_person_obj_ids[] = 121702652;
$this->developers_person_obj_ids[] = 327814126;
$this->developers_person_obj_ids[] = 752931803;
$this->developers_person_obj_ids[] = 447939755;
$this->developers_person_obj_ids[] = 994156917;
$this->developers_person_obj_ids[] = 55402045;
$this->developers_person_obj_ids[] = 843956388;

// warl: iznamenskiy
$this->developers_person_obj_ids[] = 543134477;
$this->developers_person_obj_ids[] = 882980843;

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
// vdm: боты Дарьи Колганихиной
$this->mailingBots['dako'] = array(
    399842925, // gmail
    391980355, // corp
);
// vdm: боты vdm
$this->mailingBots['vdm'] = array(
    15311282, // @yandex.ru
    359815127, // @whotrades.net
);
$this->mailingBots['gorin'] = array(
    293765032, // corp
    890702506, // gmail
    788746762, // yandex
);
// dz: боты dz
$this->mailingBots['dz'] = array(
    6096705,   // @whotrades.org
    143368613, // @corp.finam.ru
);
//warl: админы блогов (like comon.ru) since: #WHO-2443
$this->admins_blogs_person_obj_ids = array(
    684053473,
    148109734,
    681259597,
);

$this->gmaps_api_key = 'ABQIAAAAjA74xz1T-S7jdtvy-KDI3BSOKXrVXVcNSilfPxyuLrsuk-YzdBTannIrORA3LVpjPL-aYobBa6XhZg';

$this->chartsLocationHost = 'us-charts.whotrades.com';

$this->download_links['metatrader_android'] = "https://play.google.com/store/apps/details?id=net.metaquotes.metatrader4&feature=search_result#?t=W251bGwsMSwxLDEsIm5ldC5tZXRhcXVvdGVzLm1ldGF0cmFkZXI0Il0";
$this->download_links['metatrader_ios'] = "http://itunes.apple.com/en/app/metatrader-4/id496212596";
$this->download_links['metatrader_ios_ru'] = "http://itunes.apple.com/ru/app/metatrader-4/id496212596";
$this->download_links['metatrader_mobile'] = "http://www.finam.ru/files/mt4mobilesetup.cab";
$this->download_links['metatrader_mobile_se'] = "http://www.finam.ru/files/mt4mobilesetup.se.cab";
$this->download_links['metatrader_multiterminal'] = "http://files.metaquotes.net/3117/mt4/whotrades4multisetup.exe"; //
$this->download_links['mobile_trader'] = "http://www.finam.ru/howtotrade/mobiletrader/default.asp";
$this->download_links['transaq_handy'] = "http://charts.finam.ru/1/transaqhandy.rar";
$this->download_links['transaq_mma'] = "http://www.finamfx.ru/files/TransaqMMA.exe";
$this->download_links['finamtrade_android'] = "https://play.google.com/store/apps/details?id=ru.finam.android";
$this->download_links['finamtrade_ios'] = "http://itunes.apple.com/ru/app/ifinam/id434829194?mt=8";

$this->download_links_options['metatrader_android']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'MetaTrader for Android', 'app_type' => 'Android'
);
$this->download_links_options['metatrader_ios']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'MetaTrader for iOS', 'app_type' => 'iOS'
);
$this->download_links_options['metatrader_mobile']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'MetaTrader 4 Mobile', 'app_type' => 'Windows mobile'
);
$this->download_links_options['metatrader_mobile_se']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'MetaTrader 4 Mobile Smartphone Edition', 'app_type' => 'Windows mobile'
);
$this->download_links_options['metatrader_multiterminal']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'MetaTrader 4 MultiTerminal', 'app_type' => 'PC'
);
$this->download_links_options['mobile_trader']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'Mobile Trader', 'app_type' => 'Mobile'
);
$this->download_links_options['transaq_handy']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'xetra', 'type' => 'demo',
    'app_title' => 'Transaq Handy', 'app_type' => 'Windows mobile'
);
$this->download_links_options['finamtrade_android']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'FinamTrade for Android', 'app_type' => 'Android'
);
$this->download_links_options['finamtrade_ios']['interest'] = array(
    'interest' => 'TradeApplication', 'market' => 'forex', 'type' => 'demo',
    'app_title' => 'FinamTrade for iOS', 'app_type' => 'iOS'
);

$this->open_account_links['transaq-micex-rts'] = "http://www.finam.ru/howtotrade/demos00005/";
$this->open_account_links['finamtrade'] = "http://www.finam.ru/howtotrade/demos00008/";
$this->open_account_links['tradecenter'] = "https://tc.finam.ru/";

$this->email_whitelist_via_directory_system = 0;

$this->forceNevada = array(
    'invites_to_stop' => 1, // show nevada if less than this value
    'period' => '1 day' // and not too often
);

// vdm: disable deprecated php logs
$this->debug_critical_errors_location_dir = null;

// - Moderators' interface settings -
$this->mdr['menus']['admin_comon_instruments'] = "Instruments";
$this->mdr['menus']['admin_instruments_black_words'] = "IA Black words";
$this->mdr['menus']['admin_instruments_autotagging_test'] = "IA autotagging";
$this->mdr['menus']['admin_instruments_company_events'] = "Company events";
$this->mdr['menus']['admin_instruments_exchange_items'] = "Биржи";
$this->mdr['menus']['admin_comon_portfolios'] = "Portfolios";
$this->mdr['menus']['admin_comon_session_dispatcher_guid'] = "Session Dispatcher";

//sl: max len text message
$this->twitterSystem['max_len_message'] = 420;

//sl: salt for payment password
$this->pay_password_salt = 'jkh89y79kj2980234hg87y923ekj98KJHu92';

//sl: facebook scope
$this->facebookComSystem['scope'] = 'email,publish_stream,user_birthday,read_friendlists,read_stream';

//sl: Enable friend registration
$this->invite_accept_register = true;

//sl: referal percent for invited friends
$this->referal_friends_percent = 0.1;

//warl:
$this->max_attempts_trading_password_input_smscode = 5;
$this->max_sms_messages_quota = 1;
$this->period_sms_messages_quota = '1 minutes';
$this->max_marketwatch_elements = 10;

$this->marketwatch_default_list = array(
    'forex' => array(
        82548, // EURUSD
        75216 // GBPUSD
    ),
    'xetra' => array(
        35271, //SIEMENS
        35296 // BMW
    ),
    'nysdaq' => array(
        75022, // APPLE
        75045 // GOOGLE
    )
);

$this->order_fake_instrument_specific_fields = array(
    41112 => array( //Apple
        'condition_price' => 308.6,
        'operation_price' => 308.6
    ),
    66736 => array( // Google
        'condition_price' => 484.55,
        'operation_price' => 484.55
    ),
    75175 => array( //EUR vs USD
        'opening_rate' => 1.30639
    )
);

//warl: basic HTTP-auth login/password for users of the prohibited countries
$this->prohibited_countries_access = array(
    'login' => 'whotrades_usa',
    'password' => 'Uisn1u28DBw'
);

//warl: @TODO: Add real events and channels
$this->eventChannels = array('EventName' => array('channel1', 'channel2'));
$this->questionnaire_email = 'open@whotrades.eu'; // al: and used in subscribe template.
$this->questionnaire_email_sh = 'noreply@whotrades.info'; // ag: Since #WTT-539.
$this->hidden_duplicate_email['WTLTD'] = 'uvedfx@corp.finam.ru';
$this->hidden_duplicate_email['WTSH'] = 'uvedlite@corp.finam.ru';

//warl: smart notification config and available strategy list
$this->smartNotificationList = array(
    'PositiveBalance' => array(),
    'NegativeBalance' => array(),
    'Alright' => array('settings' => array('percentageOfExcess' => 10)),
    'EverythingIsBad' => array('settings' => array('percentageOfExcess' => 60)),
    'OrderProfit' => array('settings' => array('profitOrderLimit' => 100)),

    'OrderCount' => array('settings' => array('OrderCountLimit' => 30)),

    'OrderLossCount' => array('settings' => array('OrderLossCountLimit' => 10)),
    'OrderProfitCount' => array('settings' => array('OrderProfitCountLimit' => 10))
);

//warl: since #WHO-2042
$this->tradingNotificationDemoAccountsState = array(
    'total_greetings_num' => 15,
    'profit_min' => 1,

    'recommendation_groups' => array(
        'profit' => array(
            array('name' => 'strategy', 'total' => 4),
            array('name' => 'blog', 'total' => 3),
            array('name' => 'friends', 'total' => 2),
            array('name' => 'settings_account', 'total' => 2),
            array('name' => 'cabinet', 'total' => 2),
            array('name' => 'settings_profile', 'total' => 2),
            array('name' => 'cabinet_transactions', 'total' => 2),
            array('name' => 'learning', 'total' => 2),
            array('name' => 'groups_offtopic', 'total' => 2),

        ),
        'loss' => array(
            array('name' => 'groups_markets', 'total' => 2),
            array('name' => 'groups_offtopic', 'total' => 2),
            array('name' => 'settings_account', 'total' => 2),
            array('name' => 'strategy', 'total' => 7),
            array('name' => 'learning', 'total' => 3),
        )
    )
);

//warl: since #WHO-2035
$this->smartNotificationWeeklyDaySchedule = 'Sunday'; //от Sunday до Saturday как в date()
$this->smartNotificationWeeklyActivitiesPeriod = 'last Monday';

//warl: since #WTS-125
$this->smartNotificationRatedBlogPosts = array(
    'enabled' => false,
    'defaultExposureSpamValue' => 0.3,
    'dailyIncrementalExposureSpamValue' => 0.02,
    'minimumExposureSpamValueForSchedule' => 0.01,
    'afterClickIncrementalValue' => 0.1,
    'withoutClicksSomeTime' => 0.1,

    'minimumBlogPostsInCollectionBeforeMailing' => 4,
    'personIdNotification' => array(293765032), // gorin@corp.finam.ru

    'imageMailSize' => array('width' => 220, 'height' => 150)
);

$this->blogPostMinSize = array('width' => 150, 'height' => 100);

$this->smartNotificationStrategy['periodical'] = array('NoFriends', 'NoTradingFriends', 'NextAchievement');

$this->MonitoringCreateRealAccount['email'] = '_WT_RealClient_Workflow@corp.finam.ru';
$this->MonitoringCreateRealAccount['start'] = '+ 1 day 00:00:00';
$this->MonitoringCreateRealAccount['period'] = '1 day';

$this->CrmSystem['api']['url'] = "http://crm.whotrades.com/json-rpc.php";
$this->CrmSystem['api']['timeout'] = 20;
$this->CrmSystem['db']['default']['dsn'] = $this->DSN_DB3;

$this->CrmSystem['pgq']['time_live'] = 24*3600;

//lk: since #who-109
// ----  UDP Settings --------
$this->udpSystem['clients']['dictionary'] = array(
    'target' => 'phplogs-udp-1.local:1115',
);

//lk: since #who-261
// ----  GeoIp Settings --------
$this->geoIpSystem['db']['location'] = '/var/www/geo2ip-data/GeoLiteCity.dat';
$this->geoIpSystem['mapToNull'] = array('EU');


$this->contestTransferLastDay = '2012-09-01';

$this->contestBlogStar['enabled'] = true;
$this->contestInvestOlympic['enabled'] = true; // ad: since #WTT-306
$this->contestJaguar2014['enabled'] = true; // ad: since #WTT-800
$this->contestIndianOlympic['enabled'] = true; // dz: since #WTT-1070

//va: since #who-671
// Rendering dictionary keys instead of words options
$this->renderDictionaryKeysCookie      = 'renderDictionaryKeys';
$this->checkRenderDictionaryKeysCookie = 0; // do we need to check cookie ? (set to 0 in prod mode)

//warl: since #WHO-923
$this->signalRepeaterAccountMinValueByCurrency = array(
    'USD' => 10,
    'EUR' => 10,
    'RUB' => 300,
    'GLD' => 10
);
//lk: since #WHO-1473
$this->signalRepeaterSubscriptionExpiredOnOffset = 10 * 60; //10 minutes
//lk: since #WHO-1544
$this->signalRepeaterStrategyFeeValueBounds = array(
    'percent' => array('min' => 0, 'max' => 50),
);
//lk: period from past to now. since #WHO-2739
$this->signalRepeaterStrategyTradingInstrumentsPeriod = 7 * 24 * 3600; // 1 week to past
//lk: subscription trade transaction. #WHO-1089
$this->signalRepeaterSubscriptionTradeTransactionsPeriod = 30 * 24 * 3600; // 1 month to past
$this->signalRepeaterSubscriptionTradeTransactionsLimit = 50;

//bn: @since #WTT-205
$this->signalRepeaterFullFunctionality = false;

//lk: since #WHO-3738
$this->TradeRepeaterSystem['strategy']['comissionPercent'] = array('min' => 0.0, 'max' => 50.0, 'default' => 0.0);
// lk: since #WHO-3891. -2 day because day ratio for yestarday cod be not stored yet
$this->TradeRepeaterSystem['strategy']['simulationDate'] = array('min' => '-1 month', 'max' => '-2 day');

$this->TradeRepeaterSystem['slaveAccount']['default'] = array(
    'id' => 1,  // bn: Для тестирования на фейковых даных, чтобы не генерить каждому данные идут для нуль-аккаунта,
    'created' => 'now',
    'modified' => 'now',
    'statusDid' => 1,
    'personId' => 0,
    'guid' => null,
    'balance' => 0.0, // lk: strict float
    'profit' => null  // lk: null|float
);
// lk+vdm: минимальная сумма подписки увеличена до 10$ по устной просьбе dmsh
// lk: минимальная сумму подписки вернули обратно до 1$ по устной просьбе dmsh 22/11/2013
// bn: 10$ @since #WTT-347
$this->TradeRepeaterSystem['slaveAccount']['balance'] = array('min' => 10.0);
$this->TradeRepeaterSystem['slaveAccount']['maxSubscriptionsCount'] = 10;
// since #WHO-3898
$this->TradeRepeaterSystem['slaveAccount']['profitUpdatePeriod'] = 30; // 30 sec, no more often
// lk: compare with external service with 2 digits of precision. float strictly! since #WHO-4153. see http://www.php.net/manual/en/language.types.float.php
$this->TradeRepeaterSystem['slaveAccount']['moneyCompareEpsilon'] = 0.01;

// bn: since #WHO-3848
$this->TradeRepeaterSystem['payment'] = array();

// bn: since #WHO-3895
$this->TradeRepeaterSystem['subscription'] = array();
// lk: since #WHO-4611
$this->TradeRepeaterSystem['subscription']['profitStatMaxSize'] = 60; // points at chart
// lk: automatic GC for closed subscriptions profitability history
$this->TradeRepeaterSystem['subscription']['profitStatTimeToLive'] = 172800; // 60*60*24*2 ttl in seconds, zero to no expiration. Have to be ge external service data produce period.

// bn: @since #WTT-339, TTL for real account balance renew, seconds
$this->TradeRepeaterSystem['payment']['realAccountBalanceUpdateTtl'] = 60 * 5;
// bn: @since #WTT-339, minimal payment for currencies
$this->TradeRepeaterSystem['payment']['accountMinValueByCurrency'] = array(
        'USD' => 50,  // bn: @since #WTT-1128
        'EUR' => 40,
        'RUB' => 2000,
        'GLD' => 10
);
$this->TradeRepeaterSystem['mongo'] = array(
    'dsn' => 'mongodb://mgdb-0-1.iss.local:27017',
    'db' => 'TradeRepeater',
);

//lk: since #WHO-3583
$this->learning['payment']['course']['salt'] = 'tJhggSNY3AfJEzG%hupkBrcWc6obJm@Sf*r61gF1';

//sl: fardcode only for dev #WHO-926
$this->backoffice_minus_money = false;

// kz: #WHO-2372
$this->finam_demo_trading_reg_salt = 'HJBu7bkjb567fgjh65hgbjhBJH9B8098hkh9KJH1';
$this->islands_reg_salt = '46v3qUHGVn5@36vc42u3c45!bbn52346v/sMKJN';
$this->learning_reg_salt = 'KKASnrhi2(1o0jgi93yfhbsk39UJWH#@2k24k';
$this->mirtesen_reg_salt = 'Kek38HE91irK#@92jkg03222kg9031kd';
$this->invest_start_reg_salt = 'jhsdufh28H*@ni24ifbkw299tn3k0';

// kz: #WHO-1167
$this->backoffice_expire_period = 60;

// lk: TODO: kill call getcwd() in config (after kz) 20/07/2013
// Market system
$this->pdf_templates_path = getcwd() . "/../../misc/thirdparty/templates/pdf/";

// lk: chart config, since #WHO-1681
$this->marketsSystemChart['points']['number']['min'] = 2; //hide charts with less points number
$this->marketsSystemChart['points']['number']['max'] = 40;
// lk: since #WHO-3735, #WHO-4212, #WHO-3891
$this->marketsSystemStat['startStoreProfitRatioDateTime'] = '2013-08-21T18:00';
// lk: since #WHO-4568 max stored intraday items per account
$this->marketsSystemStat['intraday']['accountListMaxSize'] = 60; // zero to no limit
// lk: automatic GC for deleted account data
$this->marketsSystemStat['intraday']['accountListTimeToLive'] = 604800;  // 60*60*24*7 ttl in seconds, zero to no expiration. Have to be ge external service data produce period.

// bn: special "money" tickers, @since #WTT-320
$this->marketsSystemPortfolio['specialMoneyTickers'] = array(
        'MoneyFOND'         => 1,
        'MoneyFOND_MICEX'   => 1,
        'MoneyUS'           => 1,
        'MoneyFrankfurt'    => 1
);

$this->wt_inc_fax = '+1 212 483 9358';
$this->wt_inc_phone = '+1 646 346 1000';
$this->wt_usa_phone = '+44 020 70162199';
$this->wt_inc_email = 'info@whotrades.com';
$this->wt_ltd_email = 'info@whotrades.eu';

$this->wt_24h_phone = '+1 718 42 53 176';
$this->wt_24h_email = '24_support@corp.whotrades.eu';

$this->pdf_template = array (
    "Agreement" => array (
        "ru" => array (
            "filename" => "BR AGREEMENT Finam Ltd.pdf",
            "pages" => array (
                "1" => array (),
                "2" => array (
                    array ("key" => "fio",     "X" => "29",    "Y" => "152"),
                    array ("key" => "number",  "X" => "34",    "Y" => "219"),
                    array ("key" => "date",    "X" => "69",    "Y" => "219"),
                ),
            )
        ),
        "en" => array (
            "filename" => "Brokerage Regulations Appendix 1 - signed by both parties.pdf",
            "pages" => array (
                "1" => array (
                    array ("key" => "fio",     "X" => "29",    "Y" => "80"),
                    array ("key" => "full_date","X" => "167",  "Y" => "61"),
                ),
                "2" => array (
                    array ("key" => "fio",     "X" => "31",    "Y" => "88"),
                    array ("key" => "number",  "X" => "35",    "Y" => "157"),
                    array ("key" => "date",    "X" => "64",    "Y" => "157"),
                ),
            )
        ),
    )
);

// va: captcha engine being when "default" is provided
$this->defaultCaptchaEngine = 'simple';

// va: recaptcha support
// va: TODO delete following config key
$this->reCaptchaPublicKey  = '6Le_H9USAAAAADfNUImWkgUQBcl4bkRutClxXDAj';
$this->reCaptchaPrivateKey = '6Le_H9USAAAAAOvSUseSW_TVzcrVWtPLekFjmYqN';

// va: since #WHO-932
$this->mdr_messages_item_lcid_cookie = 'mdr_messsages_item_lcid';

// Content Moderation System
$this->CmdSystem['api']['url'] = "http://cmd.whotrades.com/json-rpc.php";
$this->CmdSystem['api']['timeout'] = 20;
$this->CmdSystem['api']['routeToModerationUnitUrl'] = 'http://cmd.whotrades.com/index/route-to-moderation-unit/external-id/';
$this->CmdSystem['db']['default']['dsn'] = $this->DSN_DB3;
$this->CmdSystem['whotradesProvider'] = 'whotrades';

// va: since #WHO-1196
$this->personsApplicationAuthSalt = '2d1ae34f60ed2a98f987d9c127dbb63a';

//warl: exotic options
$this->privateKeyPackedWtToken = 'SKk21kWK53215rk';

//warl:

$this->pingExternal['yandex']['blogs']['url'] = 'http://ping.blogs.yandex.ru/RPC2';
$this->pingExternal['yandex']['blogs']['timeout'] = 30;

//Share system
$this->shareSystem['DB']['Connection'] = 'DSN_DB4';

$this->personAuthComonRuSalt = 'Afmk3k18(!@Hnfk2,a!!@tgb;{PKSCSgr332gm';

$this->personAuthLearningSalt = 'KJAhnsnt29!*(H39hgKKD!oedn43*!(U(Rbwkwb';

$this->personAuthMirtesenSalt = 'SKj132489!IH5935923Kdh3jk2l490003';

$this->personAuthExoticOptionsSalt = 'gemo*@LrnLK124MNksk3l2!';

$this->personAuthIslandsSalt = '326h!sjhfgjk2,aytlh65kjd*kd37jdf';

$this->blogPostAddCategoryDefault = null;

//an: Переделать на использование abbr, так как айдишники зависимы от сервера (на деве одни, на проде - другие)
$this->blogPostsTopInstruments = array(
    'EURUSD',
    'AUDUSD',
    'USDCAD'
);

$this->blogPostsTopInstrumentsBig = array(
    'EURUSD',
    'AUDUSD',
    'USDCAD'
);

// import groups rating factor @see GroupsSysten\Model\Local\Import::setGroupRating
$this->importGroupRatingFactor = 1;

$this->blogsSystemMostDiscussedRatingMinValue = 0;

$this->blogsSystemFilterNewRatingMinValue = 0;

$this->commentsNotification = true;

$this->users_from_comon_ru_get_param = "ssctowt";

$this->comonru_location = 'http://comon.ru/';

$this->comonru_registration_iframe = 'http://msk-comonrep2.office.finam.ru:81/wt/'; // TODO установить правильный редирект

$this->comonru_privacy_policy = 'http://www.finam.ru/files/politikaPd.docx';

$this->server_learn_location = 'http://learning.whotrades.com/';

$this->commentsOnPage = 30;

$this->recentCommentsInWidget = 20;
$this->recentCommentsRefreshingTime = 5000;

$this->recentCommentsMinRating = 600;

$this->recentCommentsMaxCharts = 8;

$this->recentCommentsMinRatingInBlogPost = 0;

$this->notificationsCount = 10;

//id: WHO-1863: time to go (in seconds), before blogpost becomes read-only.
$this->blogPostEditTimeout = 60 * 60; // 1 hour
// id: WHO-1894: minimum rating score for user to be able to add blogpost in "markets" blog:
$this->blogPostRatingForMarket = 2500;

$this->autofollow_objects = array(
    'zh' => array(
        //array('object_id' => 917775720),
        array('object_id' => 161442936),
        //array('object_id' => 445809782)
    ),
    'en' => array(
        array('object_id' => 934616451),
        //array('object_id' => 894170857),
        //array('object_id' => 240213842),
        //array('object_id' => 839039587),
    ),
    'es' => array(
        array('object_id' => 925431361),
        //array('object_id' => 528542134),
        //array('object_id' => 456318740)
    ),
    'th' => array(
        array('object_id' => 500941052),
        //array('object_id' => 742646046),
        //array('object_id' => 470318488)
    ),
    'ru' => array(
        array('object_id' => 738327126),
    )
);

// ak: to disable some scripts from chinese version since #WTS-1214 todo: extend this as config or remove
$this->disableExternalSocials = false;

//warl: sience #WHO-2587
$this->realAccountLcidMapConvert = array(
    'ru' => array('ru')
);
$this->realAccountLcidConvertDefault = array('en');

$this->showEmailRequestPopupByUtm = array(
    array(
        'utm_medium' => 'test',
    ),
    array(
        'utm_source' => 'marketgid',
        'utm_campaign' => 'blogs' //warl: change from aandryuschenko request at 25.03.2013
    )
);

$this->bonusForForexRealAccount = array(
    'islands' => array( //reg_type
        'utm_params' => array(
            array(
                'utm_campaign' => 'twenty-bucks'
            )
        ),
        'bonus_amount' => 20,
        'zero_hour' => '+3 months'
    )
);

//warl: stupid hack for release-25
//TODO id!
$this->external_lib_dir = '/home/release/build/comon/lib/';

//warl: TODO пока нет информации о прод конфигурации
$this->activityMarketsUrl = '';

$this->exoticOptionsAppUrl = 'wtexop://onauth';
$this->eo_android_app_url = 'https://play.google.com/store/apps/details?id=com.whotrades.options';
$this->mma_android_app_url = 'https://play.google.com/store/apps/details?id=com.whotrades.mct';
$this->mma_ios_app_url = 'https://itunes.apple.com/ru/app/id805488290';

$this->exoticOptionsJsLocationUrl = 'https://opt.whotrades.com/html5/wbo-1.06/whobetson.js';

$this->privateOfficeRequestOldPasswordTimeExpire = 5 * 60; //5 minute

$this->chartsLocationUrlJsVersion = '0.16.28';  //prev '0.16.24'

$this->externalContentLoader = array(
    'finam_news' => array(
        'sections' => array(
            1 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=1',
                        'key' => 'external_content:finam_news_section_1_page_1'
                    )
                )
            ),
            2 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=2',
                        'key' => 'external_content:finam_news_section_2_page_1'
                    )
                )
            ),
            3 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=3',
                        'key' => 'external_content:finam_news_section_3_page_1'
                    )
                )
            ),
            4 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=4',
                        'key' => 'external_content:finam_news_section_4_page_1'
                    )
                )
            ),
            5 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=5',
                        'key' => 'external_content:finam_news_section_5_page_1'
                    )
                )
            ),
            6 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=6',
                        'key' => 'external_content:finam_news_section_6_page_1'
                    )
                )
            ),
            7 => array(
                'pages' => array(
                    1 => array(
                        'url' => 'http://www.finam.ru/service.asp?name=news-belt&action=page&external=1&page=1&section=7',
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
                        'url' => 'http://www.finam.ru/rss/RSS_webinar.asp?n=1',
                        'key' => 'external_content:webinar_section_1_page_1'
                    )
                )
            ),
        ),
        'content_type' => 'rss'
    )
);

$this->enableLanguageDetectionApi = true;
$this->languageDetectionApiKey = '5c2389e1663509dc2311561c531e6929';

// iv: #WHO-4234
$this->externalContentUtmProxiedHosts = array(
    'www.finam.ru',
    'finam.fm',
    'bonds.finam.ru'
);

$this->showRememberSitePrompt = true;

$this->charts_default_id = 80334; // mars: default 15 minutes
$this->charts_default_pitch = 60; // mars: default 15 minutes

//bn: configuration for techical notifications
$this->mailingSystem['technical'] = array(
    'defaultFromEmail'	=> 'noreply@finam.ru',
    'defaultFromName'	=> 'support',
    'trouble_email' 	=> 'spam-incorrect-phone@whotrades.org', 	// email for report trouble form
    'form_email' 	=> 'spam-incorrect-phone@whotrades.org',	// email for feedback form
    'wrong_phone_email' 	=> 'spam-incorrect-phone@whotrades.org',	// email for wrong phone form
);

$this->mailingSystem['application_exception_notify'] = array(
        'core' => array(),
        'go2trade' => array(
                '_webcab_errors@corp.finam.ru',
        ),
);

$this->tradePlatforms = array(
    'whotrades_plus' => array(
        'salt' => 'a80k^0sYqYPi4DB0wG8x)gvPE;n^FHbvNIKBtjaZ',
        'url' => array(
            'demo' => 'https://demo-trading.whotrades.com/User/LogOnByToken',
            'real' => 'https://us-trading.whotrades.com/User/UserInformationEntry'
        )
    )
);

// ag: Remove realAccountQuestionnaireVersion. Since #WTT-188

// ad: #WTI-238
$this->realAccountOnlineOfficeGuid = '3F24F973-E56C-4E74-83EE-4D816910A6A0'; // Kiev

$this->selfSign['v1'] = 'ss@842kkadAS(@3qhsadks';
$this->selfSign['expire'] = 3600*24;
$this->selfSign['maxUsages'] = 25;

//warl: exclude groups
$this->clientAssistance['exclude_group_ids'] = array(
    $this->group_exotic_options_group_id,
    $this->group_usa_group_id,
    30937503660, // group_mma_group_id
);

$this->clientAssistance['external']['backOffice']['period'] = '1 week';

$this->wt_yandex_metrika_id = 21910372;

$this->returning_email_duration_after_registration = 2*3600*24;
$this->returning_email_duration_after_confirmation = 2*3600*24;

// bn: @since #WTT-63, @see PgQ_EventProcessor_EnterpriseService::sendNotification
$this->EnterpriseService['notificationGroups'] = array (
    'core' => array(
        'sl@whotrades.net', 'vdm@whotrades.net', 'lk@whotrades.net', 'dmsh@whotrades.net',
    ),
    'signalRepeater' => array(
        'dev-sr@whotrades.net',
    ),
    'tradeRepeater' => array(
        'lk@whotrades.net', 'vdm@whotrades.org', 'dmsh@whotrades.org', 'dpzhuravlev@corp.finam.ru',
        // lk: extra recipients case since #WTT-63 10/01/2014
        'external' => array('idubadenko@corp.finam.ru', 'ysoldatenkov@corp.finam.ru'),
    ),
    //lk: since #WTT-340
    'backOffice' => array(
        'lk@whotrades.net', 'vdm@whotrades.org', 'dmsh@whotrades.org'
    ),
    'backOfficeCompromisedGuid' => array(
        'sl@whotrades.net',
        'vdm@whotrades.net',
        'lk@whotrades.net',
        'dmsh@whotrades.net',
        'agorlanov@corp.finam.ru',
    ),
    'backOfficeSupport' => array(
        'fm-support@corp.finam.ru',
        'turyansky@corp.finam.ru',
        'dorofeev@corp.finam.ru',
        'protorsky@corp.finam.ru',
        'tokarev_s@corp.finam.ru',
        'agorlanov@corp.finam.ru',
    ),
);

$this->personalBanner = array(
    'width' => 240,
    'height' => 400,
    'reservedShowQuota' => 0.2 // iv: сколько процентов показов конкретного баннера забирает себе whotrades
);

$this->constructor['widget']['settingsAvailable'] = array(
    'BlogPosts' => array('move', 'settings', 'delete'),
    'PeopleItemAchievements' => array('move', 'settings', 'delete'),
    'InstrumentsTopChange' => array('move', 'settings', 'delete'),
    'FormulaicStrategy' => array('move', 'settings', 'delete'),
    'InstrumentsRateChange' => array('move', 'settings', 'delete'),
    'InstrumentsAccountProbability' => array('move', 'settings', 'delete'),
    'PortfolioForSale' => array('move', 'settings', 'delete'),
    'InstrumentsChart' => array('move', 'settings', 'delete'),
    'ComonConnections' => array('move', 'settings', 'delete'),
    'InstrumentsExternalHistoryIncome' => array('move', 'settings', 'delete'),
    'FormulaicIframe' => array('move', 'settings', 'delete'),
    'FormulaicPersonTradeSignals' => array('move', 'settings', 'delete'),
    'FormulaicPersonalBanner' => array('move', 'settings', 'delete'),
    'FormulaicProfileTrade' => array('settings'),
    'FormulaicRssViewer' => array('move', 'settings', 'delete'),
    'FormulaicSocialSubscribers' => array('move', 'settings', 'delete'),
    'FormulaicStaticHtmlWysiwyg' => array('move', 'settings', 'delete'),
);

$this->personalizedPages = array(
    'BlogPosts' => array('default', 'item'),
    'Charts' => array('item'),
    'GroupsItem' => array('default'),
    'PersonalSite' => array('person_charts'),
);

$this->virtualCounters = array(
    'view' => array('max_value' => 2500, 'min_factor' => 1, 'max_factor' => 15),
    'like' => array('max_value' => 35, 'min_factor' => 1, 'max_factor' => 6)
);

$this->personalSite['minHeaderBackgroundImageWidth'] = 640;
$this->personalSite['maxHeaderBackgroundImageWidth'] = 960;
$this->personalSite['minHeaderBackgroundImageHeight'] = 140;
$this->personalSite['maxHeaderBackgroundImageHeight'] = 310;

// iv: since #WTS-1060
$this->news_groups = array(
    'ru' => 30843709400,         // http://news-ru.whotrades.com
    'es' => 30397563702,         // http://news-es.whotrades.com
    'th' => 30122490256,         // http://news-th.whotrades.com
    'zh' => 30345563105,         // http://news-zh.whotrades.com
    'ar' => 30620636551,         // http://news-ar.whotrades.com
    'other' => 30030622564,      // http://news.whotrades.com
);

$this->mixin_news_posts = true;

// bn: @since #WTT-108, ttl in days
$this->MarketSystemPortfolio['BriefcaseTtl'] = 7;

$this->tradeWidget['location'] = array(
    'script' => 'https://mma-x00.whotrades.com/tradewidget-1.0.3/tradewidget.js',
    'server' => 'https://mma-x%02d.whotrades.com/jt/server',
);
// dz: аккаунты которые показываются в торговалке для гостей @since #WTT-1472
$this->tradeWidget['guest'] = array(
    'showAccounts' => array(
        array(
            'login'        => 'twA1/106160',
            'password'     => '713f8d5ba5',
            'market'       => 'mct',
            'traderSystem' => 'TDMMA1',
        ),
    )
);

$this->smsMessagesSources = array(
    'WhoTrades',
    'BackOffice',
    'Cabinet'
);

$this->smsMessagesTemplates = array(
    'bo_money_in_complete' => array(
        '/^Confirmation\scode:\s\d{4}$/'
    ),
    'bo_money_out_status_change' => array(
        '/^Confirmation\scode:\s\d{4}$/'
    ),
    'cabinet_login' => array(
        '/^\d{2}\.\d{2}\.\d{4} \d{2}\:\d{2}\:\d{2}, successful authorization to WhoTrades Private Office, IP:(?:\d{1,3}\.){3}\d{1,3}$/'
    ),
    'cabinet_trade_password_change' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_money_out_apply' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_account_create' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_contact_add' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_money_transfer_apply' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_login_apply' => array(
        '/^Confirmation code: \d{4}$/'
    ),
    'cabinet_failed_logins' => array(
        '/^\d{2}\.\d{2}\.\d{4} \d{2}\:\d{2}\:\d{2}, (three|seven) authorizations to WhoTrades Private Office failed, IP:(?:\d{1,3}\.){3}\d{1,3}$/'
    ),
);

// dz: список страниц для редиректа пользователя, если он не в своем регионе
$this->pageContentNotAvailableForRegionRedirects = array(
    'groups_item_pages_services_v2_forex' => array(
        'page'  => 'groups_item_pages_us_services_forex',
        // dz: грязный хак, потому как без ссылки, логика не работает, видимо данная переменная меняет свое значение
        'group' => &$this->group_usa_group_id
    )
);

$this->dictionaryCache = array(
    'enabled' => false,
    'path'    => '/tmp/Dictionary',
);

// ad: #WTI-147
$this->apiUniversal = array(
    'logger' => array(
        'host' => 'mongodb://mgdb-0-1.comon.local',
        'timeout' => 3,
        'db' => 'request_logger',
        'collection' => 'api_request',
        'enabled' => true,
        'filter' => array(
            'getPersonsSystem.getModelExternalForm',
            'getLearningSystem.getApi.sendRegistrationInvitation',
            'getInterestsSystem.getApi',
        )
    )
);

// ad: #WTI-178
$this->marketsSystemEtna = array(
    'demo' => array(
        'startAmount' => 1000000
    )
);

// dz: #WTT-1024 - list 'lang' => 'blog_group_id'
$this->serviceAboutLtd = array(
    'allowedGroup' => array(
        'th'    => 30122490256,
        'en'    => 30030622564,
        'ru'    => 30878906682,
        'id_id' => 30747653537,
    ),
);

$this->instrumentTsn = array(
    'MR1',
    'MR2',
);

// bn: since #WTT-1597
$this->personsPortfolioForSale = array();

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!
