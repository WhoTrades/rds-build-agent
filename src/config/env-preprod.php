<?php
/**
 * Это файл с переопределением конфигруации для pre-prod контура и который должен подключаться вместо config.dev в pre-prod среде (pp)
 **/
require_once dirname(__FILE__) . '/env-prod.php';

require_once __DIR__ . '/config.enterprisesystem.pp.php';

$this->main_domain = "wtpred.net";

// vdm: с pre prod контура нельзя посылать email на внешние адреса
$this->developers_only_mail_filter = true;
$this->developers_only_mail_filter_forbidden_receiver = "forbidden+pp@whotrades.org";

$this->developers_only_mail_filter_allowed_domains[] = 'whotrades.com';
$this->developers_only_mail_filter_allowed_domains[] = 'whotrades.eu';
$this->developers_only_mail_filter_allowed_domains[] = 'whotrades.info';
$this->developers_only_mail_filter_allowed_domains[] = 'whotrades.net';
$this->developers_only_mail_filter_allowed_domains[] = 'whotrades.org';
$this->developers_only_mail_filter_allowed_domains[] = 'finam.ru';
$this->developers_only_mail_filter_allowed_domains[] = 'corp.finam.ru';
$this->developers_only_mail_filter_allowed_domains[] = 'corp.mirtesen.ru';
$this->developers_only_mail_filter_allowed_domains[] = 'gptoplearn.com'; // vdm: Added by Evgeny Zhilin's personal request

$this->mirrorDomains = array('china-test.wtpred.net' => 'wtpred.net');

// dz: аккаунты которые показываются в торговалке для гостей @since #WTT-1472
$this->tradeWidget['guest'] = array(
    'showAccounts' => array(
        array(
            'login'        => 'twA1/106421',
            'password'     => '9b8e2828b0',
            'market'       => 'mct',
            'traderSystem' => 'TDMMA1',
        ),
    )
);

$this->phpLogsSystem['service']['location'] = "http://phplogs.wtpred.net/api/";
$this->CrmSystem['api']['url'] = "http://crm.wtpred.net/json-rpc.php";

$this->finamTenderSystem['useFakeSoniqMq'] = true;

$this->instrumentTsn = array(
    'MD2'
);

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!