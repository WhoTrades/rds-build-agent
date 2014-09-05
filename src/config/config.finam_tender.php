<?php
$version = 1307695411;

$this->finamTenderSystem['debug_mode'] = 0;

$this->finamTenderSystem['useFakeSoniqMq'] = false;

// bash, yury: through comon1
$this->finamTenderSystem['postBackLocation'] = 'http://whotrades.com/api/internal/services/ftender/';

$this->finamTenderSystem['postBackAttempts'] = 3;

// ad: #WTI-147
$this->finamTenderSystem['services']['enterprise']['logger'] = array(
    'host' => 'mongodb://mgdb-0-1.comon.local',
    'timeout' => 3,
    'db' => 'request_logger',
    'input' => array( // fast-inserting buffer for raw packets
        'collection' => 'request_input',
    ),
    'storage' => array( // indexed storage for parsed packets
        'collection' => 'request_storage',
    ),
    'enabled' => true,
);

$this->finamTenderSystem['db']['default'] = array(
    'dsn' => $this->DSN_SERVICES_FTENDER,
    'connection' => 'host=pg-0-1.ftender.local port=5450 dbname=ftender user=ftender password=rhfrflbkkj',
);

$this->finamTenderSystem['signatureSalt'] = 'abrvalgft';

$this->finamTenderSystem['account_counts'] = array(
    'xetra'=>array(
                'error'=>3000,
                'normal'=>5000,
                'key'=>'pool_available_accounts_xetra_10000',
            ),
    'forex'=>array(
                'error'=>3000,
                'normal'=>5000,
                'key'=>'pool_available_accounts_forex_10000',
            ),
    'nysdaq'=>array(
                'error'=>3000,
                'normal'=>5000,
                'key'=>'pool_available_accounts_nysdaq_10000',
            ),
    'mct'=>array(
                'error'=>3000,
                'normal'=>25000,
                'key'=>'pool_available_accounts_mct_10000',
    )
);

$this->finamTenderSystem['cometServer'] = array(
    'host' => 'cmt.comon.local',
    'port' => 10010,
    'path' => '/',
    'namespace' => null,
    'alias' => 99,
);

$this->finamTenderSystem['ipc']['cometServer'] = array(
    'host' => 'cmt.comon.local',
    'port' => 10010,
    'path' => '/',
    'location' => 'http://cmt.comon.local:8088/cmt/',
    'namespace' => 'ipc',
);

$this->finamTenderSystem['cacheKvdpp']['db']['default'] = array(
    'connection' => 'host=pg-0-1.ftender.local port=5450 dbname=ftender user=ftender password=rhfrflbkkj',
);
$this->finamTenderSystem['cacheKvdpp']['memcached']['servers'] = array(
    'localhost:11211',
);

$this->finamTenderSystem['services']['datafeed-demo']['location']['pool'] = array(
    'http://us-charts-x00.whotrades.com/TA/ta/',
);
$this->finamTenderSystem['services']['datafeed-demo']['version'] = $version;
$this->finamTenderSystem['services']['datafeed-demo']['timezone'] = null;
$this->finamTenderSystem['services']['datafeed-demo']['credentials'] = array(
    'login' => 'Whotrades.TA',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);

$this->finamTenderSystem['services']['datafeed-real']['location']['pool'] = array(
    'http://us-charts-x00.whotrades.com/TA/ta/',
);
$this->finamTenderSystem['services']['datafeed-real']['version'] = $version;
$this->finamTenderSystem['services']['datafeed-real']['timezone'] = null;
$this->finamTenderSystem['services']['datafeed-real']['credentials'] = array(
    'login' => 'Whotrades.TA',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);

// vdm: 2mk: это все неправильно, за основу для Micex взят Forex, а надо Xetra
$this->finamTenderSystem['services']['micex-real']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/MT.Demo/',
);
$this->finamTenderSystem['services']['micex-real']['version'] = $version;
$this->finamTenderSystem['services']['micex-real']['timezone'] = 'Europe/Berlin';
$this->finamTenderSystem['services']['micex-real']['credentials'] = array(
    'login' => 'Whotrades.MT4.LTD.Demo',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);

$this->finamTenderSystem['services']['forex-demo']['portfolio'] = array(
    'lifetime' => 120,
    'renewal' => 60
);


$this->finamTenderSystem['services']['forex-demo']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/MT.Demo/',
);
$this->finamTenderSystem['services']['forex-demo']['version'] = $version;
$this->finamTenderSystem['services']['forex-demo']['timezone'] = 'Europe/Berlin';
$this->finamTenderSystem['services']['forex-demo']['instrumentslistSoap'] = 'ForexTrade';
$this->finamTenderSystem['services']['forex-demo']['credentials'] = array(
    'login' => 'Whotrades.MT4.LTD.Demo',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['forex-demo']['portfolio'] = array(
    'lifetime' => 120,
    'renewal' => 60
);


$this->finamTenderSystem['services']['forex-real']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/MT.Real/',
);
$this->finamTenderSystem['services']['forex-real']['version'] = $version;
$this->finamTenderSystem['services']['forex-real']['timezone'] = 'Atlantic/Azores';
$this->finamTenderSystem['services']['forex-real']['credentials'] = array(
    'login' => 'Whotrades.MT4.LTD.Real',
    'password' => 'jhs6hm03h',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['forex-real']['portfolio'] = array(
    'lifetime' => 300,
    'renewal' => 60
);

// vdm: Finam Limited
//        ecommon_MT4Real2
//        jhs6hm03h

// xetra:
$this->finamTenderSystem['services']['xetra-demo']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/Xetra.Demo/',
);
$this->finamTenderSystem['services']['xetra-demo']['transaq']['name'] = 'Fra.Transaq3';
$this->finamTenderSystem['services']['xetra-demo']['version'] = $version;
$this->finamTenderSystem['services']['xetra-demo']['timezone'] = 'Europe/Berlin';
$this->finamTenderSystem['services']['xetra-demo']['credentials'] = array(
    'login' => 'Whotrades.Xetra.Demo',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['xetra-demo']['portfolio'] = array(
    'lifetime' => 120,
    'renewal' => 60
);

$this->finamTenderSystem['services']['xetra-real']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/Xetra.Real/',
);
$this->finamTenderSystem['services']['xetra-real']['transaq']['name'] = 'Msk.Transaq3'; // TODO: -> Fra.Transaq1
$this->finamTenderSystem['services']['xetra-real']['version'] = $version;
$this->finamTenderSystem['services']['xetra-real']['timezone'] = 'Europe/Berlin';
$this->finamTenderSystem['services']['xetra-real']['credentials'] = array(
    'login' => 'Whotrades.Xetra.Real', // TODO: -> WhoTrades.Xetra.Transaq1.Real
    'password' => 'jhs6hm03h',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['xetra-real']['portfolio'] = array(
    'lifetime' => 300,
    'renewal' => 60
);

// nysdaq = nyse/nasdaq:
$this->finamTenderSystem['services']['nysdaq-demo']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/USA.Demo/',
);
$this->finamTenderSystem['services']['nysdaq-demo']['transaq']['name'] = 'Fra.Transaq5';
$this->finamTenderSystem['services']['nysdaq-demo']['version'] = $version;
$this->finamTenderSystem['services']['nysdaq-demo']['timezone'] = 'Etc/GMT';
$this->finamTenderSystem['services']['nysdaq-demo']['credentials'] = array(
    'login' => 'Whotrades.USA.Demo',
    'password' => 'bi6wevcnmo85',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['nysdaq-demo']['portfolio'] = array(
    'lifetime' => 120,
    'renewal' => 60
);

$this->finamTenderSystem['services']['nysdaq-real']['transaq']['name'] = 'rox';
// vdm: this is fake, it is not work
$this->finamTenderSystem['services']['nysdaq-real']['location']['pool'] = array(
    'http://fre-ft-wt2.ltd.finam.eu/CED/USA.Real/',
);
$this->finamTenderSystem['services']['nysdaq-real']['version'] = $version;
$this->finamTenderSystem['services']['nysdaq-real']['timezone'] = 'Etc/GMT';
$this->finamTenderSystem['services']['nysdaq-real']['credentials'] = array(
    'login' => 'Whotrades.USA.Real',
    'password' => 'jhs6hm03h',
    'accountType' => 14, // 14 - provided by Dmitry Grishin as Common_English
);
$this->finamTenderSystem['services']['nysdaq-real']['portfolio'] = array(
    'lifetime' => 300,
    'renewal' => 60
);

$this->finamTenderSystem['services']['mct-demo']['transaq']['name'] = 'TDMMA1';

$this->finamTenderSystem['services']['micex-demo']['transaq']['name'] = 'TD1';

$this->finamTenderSystem['serviceLocationUrl'] = 'http://whotrades.com/api/internal/services/ftender/';

// message broker (SonicMQ) configuration
$this->finamTenderSystem['services']['messageBroker']['credentials'] = array(
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK',
);
// transaq instrument checker/registrator
$this->finamTenderSystem['services']['messageBroker']['transaqIssueInit']['location']['soap'] = 'http://FRA-MQ3.ltd.finam.eu:3510/wt_ii/';

// vdm: @see http://wiki/pages/viewpage.action?pageId=10453073
$this->finamTenderSystem['services']['transaq']['transaq1']['timezone'] = 'Europe/Berlin'; // GMT+1
$this->finamTenderSystem['services']['transaq']['transaq1']['open_day_time'] = '07:45'; //09:45 Moscow
$this->finamTenderSystem['services']['transaq']['transaq1']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['transaq1']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['transaq1']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['Fra.Transaq3']['timezone'] = 'Europe/Berlin'; // GMT+1
$this->finamTenderSystem['services']['transaq']['Fra.Transaq3']['open_day_time'] = '07:45'; //09:45 Moscow
$this->finamTenderSystem['services']['transaq']['Fra.Transaq3']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq3']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq3']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['Msk.Transaq3']['timezone'] = 'Europe/Berlin'; // GMT+1
$this->finamTenderSystem['services']['transaq']['Msk.Transaq3']['open_day_time'] = '07:45'; // 09:45 Moscow
$this->finamTenderSystem['services']['transaq']['Msk.Transaq3']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['Msk.Transaq3']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['Msk.Transaq3']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['Fra.Transaq1']['timezone'] = 'Europe/Berlin'; // GMT+1
$this->finamTenderSystem['services']['transaq']['Fra.Transaq1']['open_day_time'] = '07:45'; // 09:45 Moscow
$this->finamTenderSystem['services']['transaq']['Fra.Transaq1']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq1']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq1']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['Fra.Transaq5']['timezone'] = 'Europe/London';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq5']['open_day_time'] = '06:45'; //09:45 Moscow
$this->finamTenderSystem['services']['transaq']['Fra.Transaq5']['close_day_time'] = '23:30';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq5']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['Fra.Transaq5']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['rox']['timezone'] = 'America/New_York';
$this->finamTenderSystem['services']['transaq']['rox']['open_day_time'] = '00:00';
$this->finamTenderSystem['services']['transaq']['rox']['close_day_time'] = '23:59';
$this->finamTenderSystem['services']['transaq']['rox']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['rox']['close_week_time'] = 'Sat 00:00';

$this->finamTenderSystem['services']['transaq']['TDMMA1']['timezone'] = 'CET'; // GMT+1
$this->finamTenderSystem['services']['transaq']['TDMMA1']['open_day_time'] = '00:10';
$this->finamTenderSystem['services']['transaq']['TDMMA1']['close_day_time'] = '22:40';
$this->finamTenderSystem['services']['transaq']['TDMMA1']['open_week_time'] = 'Mon 00:00';
$this->finamTenderSystem['services']['transaq']['TDMMA1']['close_week_time'] = 'Sat 00:00';

// vdm: list of available markets
$this->finamTenderSystem['markets'] = array(
    'forex', 'xetra', 'nysdaq', 'mct'
);

$this->finamTenderSystem['primaryMarket'] = 'forex';

//sl: service for java applet
$this->finamTenderSystem['services']['jtrade'] = array(
    'location' => 'http://fra-wtft1.ltd.finam.eu/inner/register_guid.asp',
    'clienttype' => '15',
    'demo' => array(
        'table' => 661033276, // vdm: person_id of Jacky Dan
    ),
    'real' => array(
        'table' => 661033276, // vdm: person_id of Jacky Dan
    ),
    'loginPostfix' => '@whotrades.com',
    'platforms' => array(
        'MT4.Demo' => array(
            'MetatraderRecord' => 'brMsgFR1::finam.MT4.Demo',
            'Source' => 'MD2',
            'ForexQueueName' => 'qMT4Comon_174',
            'AccountType' => 32
        ),
        'MT4.Real' => array(
            'MetatraderRecord' => 'brMsgFR1::finam.MT4.Real2',
            'Source' => 'MR1',
            'ForexQueueName' => 'qMT4Comon_174',
            'AccountType' => 16,
        ),
        'Micex.TR1' => array(
            'Source' => 'TR1',
            'AccountType' => 16,
        ),
        'Fra.Transaq3' => array(
            'BaseRecord' => 'brTradeFR1::finam.RiskPortfolio.fra_Transaq3',
            'TransaqRecord' => 'brTradeFR1::finam.Transaq.fra_Transaq3',
            'Source' => 'TD1',
            'AccountType' => 512
        ),
        'Fra.Transaq1' => array(
            'BaseRecord' => null, // vdm: Не указываем, т.к. Xetra / Nysdaq нет в базе данных бэкофиса сейчас
            'TransaqRecord' => 'brTradeFR1::finam.Transaq.fra_Transaq1',
            'Source' => 'TD1',
            'AccountType' => 512
        ),
        'Msk.Transaq3' => array(
            'BaseRecord' => null, // vdm: Не указываем, т.к. Xetra / Nysdaq нет в базе данных бэкофиса сейчас
            'TransaqRecord' => 'brMsg::finam.Transaq.Fight.En',
            'Source' => 'TD1',
            'AccountType' => 512
        ),
        'Fra.Transaq5' => array(
            'BaseRecord' => 'brTradeFR1::finam.RiskPortfolio.fra_Transaq5',
            'TransaqRecord' => 'brTradeFR1::finam.Transaq.fra_Transaq5',
            'Source' => 'TD1',
            'AccountType' => 1024
        ),
        'rox' => array(
            'BaseRecord' => null,
            'TransaqRecord' => 'brMsg::finam.ROX.Trading',
            'Source' => 'ROX',
            'AccountType' => 2048
        ),
        //an: Параметры, которые попросил Д. Гришин
        'mma-real' => array(
            'Source' => 'TMMA',
            'AccountType' => 4096
        ),
    ),
    'map' => array(
        'xetra-demo' => 'Fra.Transaq3',
        'xetra-real' => 'Msk.Transaq3', // TODO: -> Fra.Transaq1
        'forex-demo' => 'MT4.Demo',
        'forex-real' => 'MT4.Real',
        'nysdaq-demo' => 'Fra.Transaq5',
        'nysdaq-real' => 'rox',
        'mct-real'    => 'mma-real',
    ),
);

//warl
// lk: do not change config format. see MarketsSystem\TypeTradeSystemName
$this->finamTenderSystem['TradeSystemNames'] = array(
    'map' => array(
        'xetra-demo' => 'TDFF1',
        'xetra-real' => 'TR1',
        'forex-demo' => 'MD2',
        'forex-real' => 'MR1',
        'forex-real-mr2' => 'MR2',
        'forex-real-mr3' => 'MR3',
        'nysdaq-demo' => 'TDFU1',
        'nysdaq-real' => 'RX1',
        'nysdaq-real-tre1' => 'TRE1',
        'micex-real-tr1' => 'TR1',
        'micex-real-trv1' => 'TRV1',
        'micex-demo' => 'TD1', // vdm: хз что будет из-за этого, но нужно чтобы был дефолтный micex
        // #WTI-167
        // lk: будет ассерт на деве: TypeTradeSystemName::getReverseMap assert('!in_array($market, $this->reveseMap[$tsn][$type], true) && "duplicate market for same [tsn][type] not allowed - check config finamTenderSystem[\'TradeSystemNames\']"');
        // lk: закоментил дубль tsn=TD1
        //'micex-demo-td1' => 'TD1',
        'micex-demo-td2' => 'TD2',
        'micex-demo-ts1' => 'TS1',
        //lk since #WHO-4433
        'forex-slave' => 'MD1',
        'mct-real' => 'TRF1',
        'mct-demo' => 'TDMMA1'
    )
);

//warl
$this->finamTenderSystem['SessionDispatcherMaxTime'] = '1 hour';

//sl
$this->finamTenderSystem['TradeSystemClient']['active'] = 'Rpc';
$this->finamTenderSystem['TradeSystemClient']['Rpc']['url'] = $this->finamTenderSystem['postBackLocation'].'api/rpc/json/';
$this->finamTenderSystem['TradeSystemClient']['Rpc']['timeout'] = 10;

//warl: services clients

$this->finamTenderSystem['forex-demo']['client'] = 'metatrader_client';
$this->finamTenderSystem['forex-demo']['client_title'] = 'MetaTrader 4';
$this->finamTenderSystem['forex-real']['client'] = 'metatrader_client';
$this->finamTenderSystem['forex-real']['client_title'] = 'MetaTrader 4';

$this->finamTenderSystem['xetra-demo']['client'] = 'xetra_demo_client_transaq';
$this->finamTenderSystem['xetra-demo']['client_title'] = 'TRANSAQ Xetra';
$this->finamTenderSystem['xetra-real']['client'] = 'transaq_client_real';
$this->finamTenderSystem['xetra-real']['client_title'] = 'TRANSAQ Xetra';

$this->finamTenderSystem['nysdaq-demo']['client'] = 'nysdaq_demo_client_transaq';
$this->finamTenderSystem['nysdaq-demo']['client_title'] = 'TRANSAQ US Markets';
$this->finamTenderSystem['nysdaq-real']['client'] = 'rox_client_real';
$this->finamTenderSystem['nysdaq-real']['client_title'] = 'TRANSAQ US Markets';

$this->finamTenderSystem['mma-demo']['client'] = 'transaq_mma_demo_client_en';
$this->finamTenderSystem['mma-demo']['client_title'] = 'TRANSAQ MMA';
$this->finamTenderSystem['mma-real']['client'] = 'transaq_mma_real_client_en';
$this->finamTenderSystem['mma-real']['client_title'] = 'TRANSAQ MMA';

$this->finamTenderSystem['mma-demo-ru']['client'] = 'transaq_mma_demo_client_ru';
$this->finamTenderSystem['mma-demo-ru']['client_title'] = 'TRANSAQ MMA';
$this->finamTenderSystem['mma-real-ru']['client'] = 'transaq_mma_real_client_ru';
$this->finamTenderSystem['mma-real-ru']['client_title'] = 'TRANSAQ MMA';

// bn: Клиент для инвест-олимпиады
// dz: change to indian olympic #WTT-1070
$this->finamTenderSystem['mct-demo']['client'] = 'transaq_mma_indianolympic_client_en';
$this->finamTenderSystem['mct-demo']['client_title'] = 'TRANSAQ MMA';
$this->finamTenderSystem['mct-demo-ru']['client'] = 'transaq_mma_indianolympic_client_ru';
$this->finamTenderSystem['mct-demo-ru']['client_title'] = 'TRANSAQ MMA';

//warl: Искусственное ограничение передачи данных в комет в торговле
//warl: реально держит порядка 1800 при отсутствии данных в канале

$this->finamTenderSystem['mma-demo']['comet']['limit'] = array(
    'PORTFELSGROUP' => 100,
    'ONORDERS' => 100
);

$this->finamTenderSystem['nysdaq-demo']['comet']['limit'] = array(
    'PORTFELSGROUP' => 100,
    'ONORDERS' => 100
);

$this->finamTenderSystem['xetra-demo']['comet']['limit'] = array(
    'PORTFELSGROUP' => 100,
    'ONORDERS' => 100
);

$this->finamTenderSystem['forex-demo']['comet']['limit'] = array(
    'PORTFELSGROUP' => 100
);

$this->finamTenderSystem['mma-real']['comet']['limit'] = $this->finamTenderSystem['mma-demo']['comet']['limit'];
$this->finamTenderSystem['nysdaq-real']['comet']['limit'] = $this->finamTenderSystem['nysdaq-demo']['comet']['limit'];
$this->finamTenderSystem['xetra-real']['comet']['limit'] = $this->finamTenderSystem['xetra-demo']['comet']['limit'];
$this->finamTenderSystem['forex-real']['comet']['limit'] = $this->finamTenderSystem['forex-demo']['comet']['limit'];

//warl: ContestsTypes::INVEST_START = 1
//The values ​​of the balance in accounts at the contest

$this->finamTenderSystem['contest'][1]['forex']['balance'] = 200;
$this->finamTenderSystem['contest'][1]['xetra']['balance'] = 150;
$this->finamTenderSystem['contest'][1]['nysdaq']['balance'] = 200;

//warl:
$this->finamTenderSystem['package-skip-manager']['status'] = true; //enabled = true, disabled = false

//warl: fakeChannelsPref list
$this->finamTenderSystem['fakeChannelsPref'] = array(
    //same list, exp. got_data:portfels_group:
);

// ----- Start config for Enterprise Service ----- //

$this->finamTenderSystem['services']['enterprise']['transport'] = array(
    'SonicMq.Maccessor.Fra.Transaq5' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'finam.Transaq5',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP'
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.Maccessor.Fra.Transaq3' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'finam.Transaq3',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP'
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.Maccessor.TDMMA1' => array(
            'class' => '\WtTransport\SonicMq',
            'config' => array(
                'url' => array(
                    'http://brWhotradesNY.mq.finam.ru:2802/http2jms_Sync60',
                    'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms_Sync60',
                ),
                'headers' => array(
                    'X-JMS-MessageType' => 'TEXT',
                    'X-JMS-Action' => 'push-msg',
                    'X-JMS-DestinationQueue' => 'brDemoTrade::finam.maccessor.TDMMA1',
                    'X-JMS-User' => 'whotrade',
                    'X-JMS-Password' => 'RXLvPxEPdK',
                    'X-JMS-Type' => 'SOAP',
                )
            ),
            'timeout' => 10,
    ),
    'SonicMq.Maccessor.TD1' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms_Sync60',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsg::finam.Maccessor.TD1',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
            )
        ),
        'timeout' => 10,
    ),
    'SonicMq.Transaq.Fra.Transaq5' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::finam.Transaq.fra_Transaq5',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Transaq.Fra.Transaq5',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.Uchetka.Fra.Transaq5' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::finam.RiskPortfolio.fra_Transaq5',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Uchetka.Fra.Transaq5',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.Uchetka.Fra.Transaq3' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::finam.RiskPortfolio.fra_Transaq3',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Uchetka.Fra.Transaq3',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.Transaq.Fra.Transaq3' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::finam.Transaq.fra_Transaq3',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Transaq.Fra.Transaq3',
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Transaq.Msk.Transaq3' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsg::finam.Transaq.Fight.En',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Transaq.Msk.Transaq3',
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Transaq.TDMMA1' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::app.tq.dmma.vx.en',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'JSON_PACKET'
            )
        ),
        'timeout' => 10,
    ),
    'SonicMq.Transaq.TD1' => array(
        'class' => '\WtTransport\DevNull',
        'config' => array( // vdm: TODO
        ),
        'timeout' => 10,
    ),

    'SonicMq.Transaq.Fra.Transaq1' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradeFR1::finam.Transaq.fra_Transaq1',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'FRA/FRE',
                'finam_AppName' => 'WT-EnterpriseService-Transaq.Fra.Transaq1',
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Rdss' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://fra-sonic3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://fre-sonic4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'finam.Reuter.RDSS',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
                'X-JMS-Type' => 'SOAP'
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Bpm.Questionnaire.Create' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESB::IMClient.Create',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),
    'Soap.TransaqSync' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'http://msk-wt-sync1.office.finam.ru/synchronizer.asmx',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Bpm.Questionnaire.Update' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESBFR1::IMClient.Update',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),
    'SonicMq.Bpm.TradeAccounAdd' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESBFR1::IMClient.TradeAccount.Create',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Report.BrokerMT' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://msk-webapp1.office.finam.ru/Report/BrokerMT',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Report.Money' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://msk-webapp1.office.finam.ru/Client/Briefcase/Money',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Report.Balance' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://msk-webapp1.office.finam.ru/Client/Balance',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Report.Balance.Slow' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://msk-webapp1.office.finam.ru/Client/Balance',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 3600
    ),
    //lk: for real account profit. since #WHO-1019
    'Soap.BackOffice.Reports' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Reports',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Reports.Slow' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Reports',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 3600
    ),

    'Soap.BackOffice.Reports.ClientAssistanceCommission.AccountsLinkCreate' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Reports',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 3600
    ),

    'Soap.BackOffice.Reports.ClientAssistanceCommission.CommissionByAgent' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Reports',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 3600
    ),

    'Soap.BackOffice.Informations' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Informations',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Soap.BackOffice.Informations.Slow' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Informations',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 3600
    ),
    'Soap.BackOffice.ClientChange' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'https://bofm.office.finam.ru/BackOffice/Client',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.BackOffice.Subscription' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESBFR1::finam.wt.Notification.BOLtd',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.BackOffice.PaymentsProcessing' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESBFR1::finam.wt.Notification.BOLtd',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'Http.Webinar.PaymentsProcessing' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://www.finam.ru/scripts/payments/default.asp?name=whotrade',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ),
        ),
        'timeout' => 10
    ),

    // ad: example for #WHO-4125
    /*'Http.Test.PaymentsProcessing' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://whotrades.ad.whotrades.net',
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
            ),
        ),
        'timeout' => 10
    ),*/

    'Http.ExternalFl.PaymentsProcessing' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'https://cabinet.finam.eu/api/updatepayment/',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ),
        ),
        'timeout' => 10
    ),

    'SonicMq.Bpm.PaymentsProcessing' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESB::IMClient.Create.TransactionMoneyIn',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    //lk: Learning since #WHO-3583
    'SonicMq.Learning.PaymentsProcessing' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brWhotradesNY::dist.learning.payments',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.Bpm.Assignment' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESBFR1::IMClient.Order.Create',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.ComonRu.Mobile' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brComon.mq.finam.ru:2602/http2jms_Sync60',
                'http://brComon-back.mq.finam.ru:2602/http2jms_Sync60'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'comon.mobileapi.request',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.ExoticOptions.Account' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://FRA-MQ3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://FRE-MQ4.ltd.finam.eu:3510/http2jms_Sync60'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTrade::app.Option.AccountBind',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.ExoticOptions.PaymentsProcessing' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://FRA-MQ3.ltd.finam.eu:3510/http2jms',
                'http://FRE-MQ4.ltd.finam.eu:3510/http2jms'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTrade::app.Option.MoneyRecive',
                'X-JMS-ReplyTo' => 'brPayProcNY::wt.payments_processing.notification.from.SysProg',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.NonExchangeOptions.Account' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTrade::app.neoptions.operations',
                'X-JMS-ReplyTo' => 'brWhotradesNY::wt.non_exchange_options.notification.from.neoptions.account',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.BackOffice.TradeTransactions' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' =>'TEXT',
                'X-JMS-DeliveryMode' =>'PERSISTENT',
                'X-JMS-Action' =>'push-msg',
                'X-JMS-DestinationQueue' =>'brESBFR1::finam.wt.Notification.BOLtd',
                'X-JMS-User' =>'whotrade',
                'X-JMS-Password' =>'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.BackOffice.BugReport' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' =>'TEXT',
                'X-JMS-DeliveryMode' =>'PERSISTENT',
                'X-JMS-Action' =>'push-msg',
                'X-JMS-DestinationQueue' =>'brESBFR1::finam.wt.Notification.BOLtd',
                'X-JMS-User' =>'whotrade',
                'X-JMS-Password' =>'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.SignalRepeater.Sync' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms_Sync60',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms_Sync60'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'wt.strategies.request',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.SignalRepeater.Async' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'wt.strategies.request',
                'X-JMS-ReplyTo' => 'wt.strategies.response',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),

    // lk: #WHO-3737
    'SonicMq.TradeRepeater.Async' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                // lk: switch to async since #WHO-4588
                // lk: downgrade to 7.6 #WTT-387
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                // lk: switch to 7.6 broker brAutoFollowFR1 18/04/2014
                'X-JMS-DestinationQueue' => 'brAutoFollowFR1::venturefx.commands',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),

    //lk: since #WTT-340
    'SonicMq.BackOffice.AccountMoneyTransfer.Async' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                // lk: switch to async since #WHO-4588
                // lk: downgrade to 7.6 #WTT-387
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                // lk: send to BO broker brBOFMFR1
                'X-JMS-DestinationQueue' => 'brBOFMFR1::finam.BOFM.Autofollow.V2',
                // lk: receve to our brWhotradesNY
                'X-JMS-ReplyTo' => 'brWhotradesNY::wt.trade_repeater.notification.from.boltd.remittance',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),

    // lk: WHO-2797
    'SonicMq.AccountManagement.Sync' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            //lk: see http://it-portal/tasks/browse/WHO-1630?focusedCommentId=276041&page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel#comment-276041
            'url' => array(
                'http://brComon.mq.finam.ru:2602/http2jms_Sync60',
                'http://brComon-back.mq.finam.ru:2602/http2jms_Sync60'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'wt.backoffice.request',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    //lk: async since very slow register account migration via taskOneTime 20.05.2013
    'SonicMq.AccountManagement.Async' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            //lk: see http://it-portal/tasks/browse/WHO-1630
            'url' => array(
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brComon::wt.backoffice.request',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 5
    ),

    // lk: WHO-1827
    'SonicMq.TradesHistory.Sync' => array(
        'class' => '\WtTransport\SonicMq',
        //lk: http://it-portal/wiki/pages/viewpage.action?pageId=17795318
        'config' => array(
            'url' => array(
                'http://brComon.mq.finam.ru:2602/http2jms_Sync60',
                'http://brComon-back.mq.finam.ru:2602/http2jms_Sync60'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'finam.tradeshistory',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.MetaTrader.MD1' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://FRA-MQ3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://FRE-MQ4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsgFR1::finam.MT4.Common.Demo',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.MetaTrader.MD2' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://FRA-MQ3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://FRE-MQ4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsgFR1::finam.MT4.Demo',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.MetaTrader.MR1' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms_Sync60',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsgFR1::finam.MT4.Real2',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.MetaTrader.MR2' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://FRA-MQ3.ltd.finam.eu:3510/http2jms_Sync60',
                'http://FRE-MQ4.ltd.finam.eu:3510/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brMsgFR1::finam.MT4.Common.Real',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',
            ),
        ),
        'timeout' => 10
    ),
    'SonicMq.MetaTrader.MR3' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms_Sync60',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brTradesNY::app.mt4.mr3.finamgate',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            ),
        ),
        'timeout' => 10
    ),

    'Http.Finam.SmsSender' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            // 'url' => 'http://nye-ft-app1.ny.whotrades.us/sms/'
            // bn: @since #WTT-1471
            'url' => 'http://nye-ft-app1.whotrades.local/sms/'
        ),
        'timeout' => 10
    ),
    'Http.Finam.CurrencyRate' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://www.finam.ru/rss/RSS_make_currnecies_online.xml'
        ),
        'timeout' => 10
    ),
    'Http.Finam.Etna' => array(
        'class' => '\WtTransport\Soap',
        'config' => array(
            'url' => 'http://nye-trade02-p.whotrades.local:8006/UserManagementWebService',
            'headers' => array(
                'Content-Type' => 'application/soap+xml; charset=UTF-8',
            )
        ),
        'timeout' => 10
    ),
    'Http.Finam.SmsSender.Status' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-sonicdf1.ltd.finam.eu/ws_sms_check/default_new.asp'
        ),
        'timeout' => 10
    ),
    'Http.Finam.OpenInviter' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://www1.oi.local/exp4mail.php',
            'headers' => array(
                'Content-Type' => 'multipart/form-data',
            ),
        ),
        'timeout' => 10
    ),
    'Http.Finam.InstrumentList' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=finam'
        ),
        'timeout' => 10
    ),

    'Http.Finam.Bats.InstrumentList' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=bats'
        ),
        'timeout' => 10
    ),

    'Http.Finam.Micex.InstrumentList' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=micex'
        ),
        'timeout' => 10
    ),
    'Http.Finam.MicexFond.InstrumentList' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=micex_fond'
        ),
        'timeout' => 10
    ),
    'Http.MetaTrader.InstrumentList.MD1' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=mt4&source=23'
        ),
        'timeout' => 10
    ),
    'Http.MetaTrader.InstrumentList.MD2' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=mt4&source=21'
        ),
        'timeout' => 10
    ),
    'Http.MetaTrader.InstrumentList.MR1' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=mt4&source=20'
        ),
        'timeout' => 10
    ),
    'Http.MetaTrader.InstrumentList.MR2' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=mt4&source=22'
        ),
        'timeout' => 10
    ),
    'Http.MetaTrader.InstrumentList.MR3' => array(
        'class' => '\WtTransport\Http',
        'config' => array(
            'url' => 'http://fra-wtft1.ltd.finam.eu/Issues/issues.asp?what=mt4&source=20' // ag: TODO Set real value #WTI-73
        ),
        'timeout' => 10
    ),

    //crm
    'SonicMq.Asterisk.CommandQueue' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
                'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-DeliveryMode' => 'PERSISTENT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brInfra::finam.asterisk2',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123'
            )
        ),
        'timeout' => 10
    ),

    'SonicMq.Asterisk.StatusQueue' => array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
                'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http',
            ),
            'headers' => array(
                'Content-Type' => 'text/xml; charset=UTF-8',
                'X-JMS-Action' => 'pull-msg',
                'X-JMS-Timeout' => '10000',
                'X-JMS-ReceiveQueue' => 'wt.crm.notification.from.asterisk.generic',
                'X-JMS-User' => 'whotrades',
                'X-JMS-Password' => 'Ljcneg123',
            )
        ),
        'timeout' => 10
    ),
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmOffices.Sync'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brInfra.mq.finam.ru:2104/http2jms_Sync60',
            'http://brInfra-back.mq.finam.ru:2104/http2jms_Sync60'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-DeliveryMode' => 'PERSISTENT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'finam.crm.export',
            'X-JMS-User' => 'whotrades',
            'X-JMS-Password' => 'Ljcneg123',
        )
    ),
    'timeout' => 3600
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmWebForm.Async'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brInfra.mq.finam.ru:2104/http2jms',
            'http://brInfra-back.mq.finam.ru:2104/http2jms',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-DeliveryMode' => 'PERSISTENT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'finam.crm.orders',
            'X-JMS-User' => 'whotrades',
            'X-JMS-Password' => 'Ljcneg123',
        )
    ),
    'timeout' => 10
);

//lk+ag: since #WTI-36
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Response.Async'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-DeliveryMode' => 'PERSISTENT',
            'X-JMS-Action' => 'push-msg',
            // ag: Temporary Queue for responses
            'X-JMS-DestinationQueue' => 'brBOFMFR1::finam.BOFM.Responses.WT',
            'X-JMS-User' => 'whotrades',
            'X-JMS-Password' => 'Ljcneg123',
        )
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.NonTradeOrder.Async'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-DeliveryMode' => 'PERSISTENT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brBOFMFR1::finam.BOFM.Orders',
            'X-JMS-User' => 'whotrades',
            'X-JMS-Password' => 'Ljcneg123',
        )
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check'] = array(
    'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brESBFR1.mq.finam.ru:2302/http2jms_Sync60',
                'http://brESBFR1-back.mq.finam.ru:2302/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESB::finam.bpm.Messages',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',

            )
        ),
        'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send'] = array(
    'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://brESBFR1.mq.finam.ru:2302/http2jms_Sync60',
                'http://brESBFR1-back.mq.finam.ru:2302/http2jms_Sync60',
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'brESB::finam.bpm.Messages',
                'X-JMS-User' => 'whotrade',
                'X-JMS-Password' => 'RXLvPxEPdK',

            )
        ),
        'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['Fra.Transaq5'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transaqServerName' => 'fra-transaq5',
    'transport' => 'SonicMq.Maccessor.Fra.Transaq5',
    'transportTransaq' => 'SonicMq.Transaq.Fra.Transaq5',
    'transportUchetka' => 'SonicMq.Uchetka.Fra.Transaq5',
    'transportTransaqSync' => 'Soap.TransaqSync',
);
$this->finamTenderSystem['services']['enterprise']['Fra.Transaq3'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transaqServerName' => 'fra-transaq3',
    'transport' => 'SonicMq.Maccessor.Fra.Transaq3',
    'transportTransaq' => 'SonicMq.Transaq.Fra.Transaq3',
    'transportUchetka' => 'SonicMq.Uchetka.Fra.Transaq3',
    'transportTransaqSync' => 'Soap.TransaqSync'
);
$this->finamTenderSystem['services']['enterprise']['Transaq.TDMMA1'] = array(
    'user' => null, // vdm: TODO
    'password' => null, // vdm: TODO
    'transaqServerName' => 'FRE-TRANSAQMMA1',
    'transport' => 'SonicMq.Maccessor.TDMMA1',
    'transportTransaq' => 'SonicMq.Transaq.TDMMA1', // vdm: TODO: удалить после рефакторинга (вынос Maccessor)
    'transportTransaqMma' => 'SonicMq.Transaq.TDMMA1',
    //'transportUchetka' => null, // vdm: TODO
    //'transportTransaqSync' => null, // vdm: TODO
);
$this->finamTenderSystem['services']['enterprise']['Transaq.TD1'] = array(
    'user' => null, // vdm: TODO
    'password' => null, // vdm: TODO
    'transaqServerName' => 'wgame.finam.ru',
    'transport' => 'SonicMq.Maccessor.TD1',
    'transportTransaq' => 'SonicMq.Transaq.TD1',
    'transportTransaqMma' => 'SonicMq.Transaq.TD1',
    //'transportUchetka' => null, // vdm: TODO
    //'transportTransaqSync' => null, // vdm: TODO
);

$this->finamTenderSystem['services']['enterprise']['Msk.Transaq3'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transport' => null,
    'transportTransaq' => 'SonicMq.Transaq.Msk.Transaq3',
);
$this->finamTenderSystem['services']['enterprise']['Fra.Transaq1'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transport' => null,
    'transportTransaq' => 'SonicMq.Transaq.Fra.Transaq1',
);
//lk: rename MT4.LTD.Demo -> MD2
$this->finamTenderSystem['services']['enterprise']['MD2'] = array(
    'MetaTrader' => array(
        'user' => 'whotrade',
        'password' => 'RXLvPxEPdK',
        'pluginPassword' => array(
            'balanceChange' => 'WhoTradeChangeBalance123987',
            'changePasswordWithoutCheck' => 'pwdcngnch',
            'orderCreateAndCloseOffline' => 'hdtest'
        ),
        'transport' => 'SonicMq.MetaTrader.MD2',
        'metatraderClientGroups' => array( //sl: todo change groups
            'USD' => 'demoFOREX-USDWT', // vdm: Самый первый в списке является главной группой
            'EUR' => 'demoComonUSD',
            'RUB' => 'demoComonUSD',
            'GLD' => 'demoComonUSD',
        )
    ),
);
//lk: rename MT4.LTD.Real -> MR1
$this->finamTenderSystem['services']['enterprise']['MR1'] = array(
    'MetaTrader' => array(
        'user' => 'whotrade',
        'password' => 'RXLvPxEPdK',
        'pluginPassword' => array(
            'changePasswordWithoutCheck' => 'T4A3Mq8vLH3W',
        ),
        'transport' => 'SonicMq.MetaTrader.MR1',
        'metatraderClientGroups' => array(
            'USD' => 'NY-common', // vdm: Самый первый в списке является главной группой
            'EUR' => 'NY-common-EUR',
            'RUB' => 'common-RUB',
            'GLD' => 'NY-common-GLD'
        )
    ),
);
// ag: Since #WTI-392
$this->finamTenderSystem['services']['enterprise']['MR2'] = array(
    'MetaTrader' => array(
        'user' => 'whotrade',
        'password' => 'RXLvPxEPdK',
        'pluginPassword' => array(
            'changePasswordWithoutCheck' => 'T4A3Mq8vLH3W', // ag: TODO Set real value #WTI-392
        ),
        'transport' => 'SonicMq.MetaTrader.MR2',
        // ag: TODO Set real value #WTI-392
        'metatraderClientGroups' => array(
            'USD' => 'NY-common', // vdm: Самый первый в списке является главной группой
            'EUR' => 'NY-common-EUR',
            'RUB' => 'common-RUB',
            'GLD' => 'NY-common-GLD'
        )
    ),
);
// ag: Since #WTI-73
$this->finamTenderSystem['services']['enterprise']['MR3'] = array(
    'MetaTrader' => array(
        'user' => 'whotrade',
        'password' => 'RXLvPxEPdK',
        'pluginPassword' => array(
            'changePasswordWithoutCheck' => 'T4A3Mq8vLH3W', // ag: TODO Set real value #WTI-73
        ),
        'transport' => 'SonicMq.MetaTrader.MR3',
        // ag: TODO Set real value #WTI-73
        'metatraderClientGroups' => array(
            'USD' => 'NY-common', // vdm: Самый первый в списке является главной группой
            'EUR' => 'NY-common-EUR',
            'RUB' => 'common-RUB',
            'GLD' => 'NY-common-GLD'
        )
    ),
);

$this->finamTenderSystem['services']['enterprise']['MD1'] = array(
    'MetaTrader' => array(
        'user' => 'whotrade',
        'password' => 'RXLvPxEPdK',
        'pluginPassword' => null, // vdm: HACK: Этот функционал не используется
        'transport' => 'SonicMq.MetaTrader.MD1',
        'metatraderClientGroups' => array(
            'USD' => 'avtosl-USD', // vdm: Самый первый в списке является главной группой
            'EUR' => 'avtosl-EUR',
            'RUB' => 'avtosl-RUB',
        )
    ),
);

// vdm: Да, сервис без настроек. Надо его убить, перенеся парсинг в другое место
$this->finamTenderSystem['services']['enterprise']['BackOfficeClq'] = array(

);

$this->finamTenderSystem['services']['enterprise']['DocumentRequest'] = array(
    'check' => array(
        'transport' => 'SonicMq.Bpm.Messages.Check'
    ),
    'send' => array(
        'transport' => 'SonicMq.Bpm.Messages.Send'
    ),
);

$this->finamTenderSystem['services']['enterprise']['ExoticOptions']['Account'] = array(
    'transport' => 'SonicMq.ExoticOptions.Account',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['ExoticOptions']['PaymentsProcessing'] = array(
    'transport' => 'SonicMq.ExoticOptions.PaymentsProcessing',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['NonExchangeOptions']['Account'] = array(
    'transport' => 'SonicMq.NonExchangeOptions.Account',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['Questionnaire'] = array(
    'Create' => array(
        'transport' => 'SonicMq.Bpm.Questionnaire.Create',
        'login' => 'whotrade',
        'password' => 'RXLvPxEPdK'
    ),
    'Update' => array(
        'transport' => 'SonicMq.Bpm.Questionnaire.Update',
        'login' => 'whotrade',
        'password' => 'RXLvPxEPdK'
    ),
    'TradeAccounAdd' => array(
        'transport' => 'SonicMq.Bpm.TradeAccounAdd',
        'login' => 'whotrade',
        'password' => 'RXLvPxEPdK'
    ),
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeSubscription'] = array(
    'transport' => 'SonicMq.BackOffice.Subscription',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['BackOfficePaymentsProcessing'] = array(
    'transport' => 'SonicMq.BackOffice.PaymentsProcessing',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['WebinarPaymentsProcessing'] = array(
    'transport' => 'Http.Webinar.PaymentsProcessing'
);

// ad: #WHO-4125
$this->finamTenderSystem['services']['enterprise']['GenericPaymentsProcessing'] = array(
    // ad: example for #WHO-4125
    /*\PaymentsProcessingSystem\Recipients::GENERIC_MERCHANT1 => array(
        'transport' => 'Http.Test.PaymentsProcessing',
        'salt' => '3t8ers7ty4kjdssha*l&t#'
    ),*/
    \PaymentsProcessingSystem\Recipients::EXTERNAL_FL => array(
        'transport' => 'Http.ExternalFl.PaymentsProcessing',
        'salt' => '8F7ArwVn2v0Qb'
    ),
    \PaymentsProcessingSystem\Recipients::EXTERNAL_FL_SYC => array(
        'transport' => 'Http.ExternalFl.PaymentsProcessing',
        'salt' => '8F7ArwVn2v0Qb'
    ),
);

$this->finamTenderSystem['services']['enterprise']['BpmPaymentsProcessing'] = array(
    'transport' => 'SonicMq.Bpm.PaymentsProcessing',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

//lk: Learning since #WHo-3583
$this->finamTenderSystem['services']['enterprise']['LearningPaymentsProcessing'] = array(
    'transport' => 'SonicMq.Learning.PaymentsProcessing'
);

$this->finamTenderSystem['services']['enterprise']['BackOffice-BugReport'] = array(
    'transport' => 'SonicMq.BackOffice.BugReport',
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeReport'] = array(
    'default' => array(
        'user' => 'whotrades',
        'password' => 'dfw4g!ojs#13',
    ),
    'BrokerMT' => array(
        'transport' => 'Soap.BackOffice.Report.BrokerMT'
    ),
    'Money' => array(
        'transport' => 'Soap.BackOffice.Report.Money'
    ),
    'Balance' => array(
        'transport' => 'Soap.BackOffice.Report.Balance.Slow'
    ),
    'Client' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'Person' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'Account' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'Accounts' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations.Slow'
    ),
    'Platform' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'PersonChanges' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'PasswordChange' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.ClientChange'
    ),
    //lk: since #WHO-1019
    'Profitability' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Reports'
    ),
    'Agents' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'AgentsComissionByClients' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Reports.Slow'
    ),
    'AgentsComission' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Reports'
    ),
    'Agencies' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'AgreementReservation' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.ClientChange'
    ),
    'Transactions' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Reports.Slow'
    ),
    'PersonSearch' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations'
    ),
    'AccountChangesId' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        'transport' => 'Soap.BackOffice.Informations.Slow'
    ),
    //lk: since #WTT-340
    'AccountMoneyTransfer' => array(
        'user' => 'WHOTRADES',
        'password' => 'l2j5k45fvg',
        // lk: send via sonic, credintianls no need, see transport config
        'transport' => 'SonicMq.BackOffice.AccountMoneyTransfer.Async'
    ),
);

$this->finamTenderSystem['services']['enterprise']['ClientAssistanceCommission'] = array(
    'AccountsLinkCreate' => array(
        'transport' => 'Soap.BackOffice.Reports.ClientAssistanceCommission.AccountsLinkCreate',
        'login' => 'WHOTRADES',
        'password' => 'l2j5k45fvg'
    ),
    'CommissionByAgent' => array(
        'transport' => 'Soap.BackOffice.Reports.ClientAssistanceCommission.CommissionByAgent',
        'login' => 'WHOTRADES',
        'password' => 'l2j5k45fvg'
    ),
);

$this->finamTenderSystem['services']['enterprise']['Assignment'] = array(
    'transport' => 'SonicMq.Bpm.Assignment',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeTradeTransactions'] = array(
    'transport' => 'SonicMq.BackOffice.TradeTransactions',
    'login' => 'whotrade',
    'password' => 'RXLvPxEPdK'
);

$this->finamTenderSystem['services']['enterprise']['CurrencyRate'] = array(
    'transport' => 'Http.Finam.CurrencyRate'
);

$this->finamTenderSystem['services']['enterprise']['SignalRepeater'] = array(
    'tradeSystemName' => 'serverName',
    'OwnerSystem' => 'whotrades',
    'ipAddress' => '192.168.52.48',
    'transportSync' => 'SonicMq.SignalRepeater.Sync',
    'transportAsync' => 'SonicMq.SignalRepeater.Async'
);

// lk: since WHO-2797
$this->finamTenderSystem['services']['enterprise']['AccountManagement'] = array(
    'OwnerSystem' => 'whotrades',
    'ipAddress' => '192.168.52.48', //lk: TODO ensure ipAdress
    'transportSonicSync' => 'SonicMq.AccountManagement.Sync',
    'transportSonicAsync' => 'SonicMq.AccountManagement.Async',
    // lk: internal => external
    'marketCodes' => array(
        'forex'  => 'forex',
        'xetra'  => 'xetra',
        'nysdaq' => 'usa',
        'micex' => 'micex',
        'forts' => 'forts',
        'mct'   => 'mct'
    ),
    // lk: call RegisterAccount via serviceAsync instead of serviceSync
    'isRegisterAccountAsync' => true,
    // lk: since #WTT-747
    'isDeleteAccountAsync' => true,
);

//lk: since WHO-1827
$this->finamTenderSystem['services']['enterprise']['TradesHistory'] = array(
    'OwnerSystem' => 'whotrades',
    'ipAddress' => '192.168.52.48', //lk: TODO ensure ipAdress
    'transportSonicSync' => 'SonicMq.TradesHistory.Sync',
    //lk: trade transactions sonic send to
    'tradeEventQueue' => 'brWhotradesFR1::wt.trade_system.notification.from.comon.TradesHistory'
);

//lk: since WHO-3737
$this->finamTenderSystem['services']['enterprise']['TradeRepeater'] = array(
    //only one trasport, sync since #WHO-4588 + #SR-1001
    'transportSonic' => 'SonicMq.TradeRepeater.Async',
);

$this->finamTenderSystem['services']['enterprise']['ComonRuMobile'] = array(
    'OwnerSystem' => 'whotrades',
    'ipAddress' => '127.0.0.1', //warl: TODO
    'transport' => 'SonicMq.ComonRu.Mobile',
);

$this->finamTenderSystem['services']['enterprise']['SmsSender'] = array(
    'secret' => '8ung5dfhg',
    'transport' => 'Http.Finam.SmsSender'
);

$this->finamTenderSystem['services']['enterprise']['SmsSenderStatus'] = array(
    'secret' => '8ung5dfhg',
    'transport' => 'Http.Finam.SmsSender.Status'
);

$this->finamTenderSystem['services']['enterprise']['OpenInviter'] = array(
    'transport' => 'Http.Finam.OpenInviter'
);

$this->finamTenderSystem['services']['enterprise']['bats-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.Bats.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['micex-fond-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.MicexFond.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['micex-fond-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.MicexFond.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['micex-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.Micex.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['micex-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.Micex.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['xetra-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList'
    ),
    'Transaq' => 'Fra.Transaq3',
);

$this->finamTenderSystem['services']['enterprise']['xetra-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList'
    ),
    'Transaq' => 'Msk.Transaq3', // TODO: -> Fra.Transaq1
);

$this->finamTenderSystem['services']['enterprise']['nysdaq-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList',
    ),
    'Transaq' => 'Fra.Transaq5',
);

$this->finamTenderSystem['services']['enterprise']['nysdaq-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList'
    ),
);

$this->finamTenderSystem['services']['enterprise']['mct-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList'
    ),
    'Transaq' => 'Transaq.TDMMA1',
);

$this->finamTenderSystem['services']['enterprise']['micex-demo'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.Finam.InstrumentList'
    ),
    'Transaq' => 'Transaq.TD1',
);

$this->finamTenderSystem['services']['enterprise']['forex-demo']= array(
    'InstrumentList' => array(
        'transport' => 'Http.MetaTrader.InstrumentList.MD2'
    ),
    'Metatrader' => 'MD2',
);
// vdm: пришлось временно добавить этот блок конфига чтобы можно было найти по TSN InstrumentsList
$this->finamTenderSystem['services']['enterprise']['forex-slave']= array(
    'InstrumentList' => array(
        'transport' => 'Http.MetaTrader.InstrumentList.MD1'
    ),
    'Metatrader' => 'MD1',
);

$this->finamTenderSystem['services']['enterprise']['forex-real'] = array(
    'InstrumentList' => array(
        'transport' => 'Http.MetaTrader.InstrumentList.MR1'
    ),
    'Metatrader' => 'MR1',
);

$this->finamTenderSystem['services']['enterprise']['Rdss'] = array(
    'transport' => 'SonicMq.Rdss'
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeWithFormat'] = array(
    'transport' => 'SonicMq.BackOffice.Response.Async',
    // ad: packets format to be used for specific queue
    'format' => 'xml', // json
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeNonTradeOrder'] = array(
    'transport' => 'SonicMq.BackOffice.NonTradeOrder.Async',
);

// ----- And config for Enterprise Service sonic reader ---- //
$this->finamTenderSystem['services']['EnterpriseService'] = array(
    'devWt' => array(
        'location' => array(
            'http://brESBFR1.mq.finam.ru:2302/jms2http',
            'http://brESBFR1-back.mq.finam.ru:2302/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'BO' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout'=> 30000,
                    'X-JMS-ReceiveQueue' => 'finam.BOLtd.Notification.wt',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ) ,
            'BPM' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'IMClient.bpm.Notification.wt',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            )
        ),
    ),
    'bpm' => array(
        'location' => array(
            'http://brESBFR1.mq.finam.ru:2302/jms2http',
            'http://brESBFR1-back.mq.finam.ru:2302/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'DocumentRequest' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'IMClient.DocumentRequestLink.wt',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                ),
            ),
        )
    ),
    //lk: since SR-service became async
    'signalRepeater' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'SubscribeRequest' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.strategies.response',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            //lk: since #WHO-1370
            'ProfitStrategy' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.strategies.profit.response',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    'brWhotrades' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'FinamFx' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.persons.notification.from.FinamFx',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            'MtArchived' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'Whotrade.mt.ask.archived',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    'Sms' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'Generic' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.sms.notification.from.SysProg.generic',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            'Send' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.persons.request.from.any.sms_send',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    'PaymentsProcessing' => array(
        'location' => array(
            'http://brPayProcNY.mq.finam.ru:3402/jms2http',
            'http://brPayProcNY-back.mq.finam.ru:3402/jms2http',
        ),
        'timeout'  => 55,
        'queues' => array(
            'ExoticOptions' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.payments_processing.notification.from.SysProg',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            )
        )
    ),

    'Wt' => array(
        'location' => array(
            'http://brESBFR1.mq.finam.ru:2302/jms2http',
            'http://brESBFR1-back.mq.finam.ru:2302/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'BOClientCreate' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'wt.Receiver.from.BOLtd.Client.Create',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ),
            'BOClientChange' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'wt.Receiver.from.BOLtd.Client.Change',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ),
            'BOAgentCreate' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'dev.wt.Receiver.from.BOLtd.Agent.Create',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ),
            'BOAgentDelete' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'dev.wt.Receiver.from.BOLtd.Agent.Delete',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ),
            'BOOrderStatusChange' => array( // bn: очередь для получения информации об изменениях статуса заявок
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 30000,
                    'X-JMS-ReceiveQueue' => 'wt.Receiver.from.BOLtd.Order.Status.Change',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            ),
        )
    ),

    //lk: since #WHO-1827
    'TradesHistory' => array(
        'location' => array(
            'http://brWhotradesFR1.mq.finam.ru:2802/jms2http',
            'http://brWhotradesFR1-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'TradeTransaction' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.trade_system.notification.from.comon.TradesHistory',
                ),
                'auth' => array(
                    'login' => 'wt.trade_system',
                    'password' => 'FXigrNoVU'
                ),
            ),
        )
    ),

    // lk: BackOffice pull-jms, since #WHO-3340
    'BackOffice' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            // lk: money transfer MT4 -> TradeRepeater
            'Remittance' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.trade_repeater.notification.from.boltd.remittance',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            'PersonInfo' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.markets.request.from.bo.person_info',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            // ad: BO requests to check person contact data #WTI-116
            'ContactCheck' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.persons.request.from.bo.contact_check',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            'NonTradeOrder' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.crm.notification.from.bo.nontrade_order',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    // lk: pull-jms, since #WHO-3737
    'TradeRepeater' => array(
        'location' => array(
            // lk: switch to sonic 7.6 #WTT-387
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            // наши названия очередей
            'CommandResult' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    // lk: renamed since 05.08.2013, see tech-order #71250
                    'X-JMS-ReceiveQueue' => 'wt.trade_repeater.notification.from.VentureFx',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
            // lk: runtime pull-jms SINCE #WHO-3898
            'PortfolioSnapshot' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    // название очередей на стороне соника
                    'X-JMS-ReceiveQueue' => 'wt.trade_repeater.notification.portfolio.from.VentureFx',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    // lk: pull-jms, since #WHO-4531
    'ProfitStreamer' => array(
        'location' => array(
            // lk: switch to sonic 7.6 #WTT-387
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            // lk: runtime pull-jms
            'AccountProfitIntraday' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.trade_system.notification.from.profit_streamer.generic',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    //warl: since #WTS-133, pull-jms
    'Learning' => array(
        'location' => array(
            // lk: switch to sonic 7.6 #WTT-387
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'Callback' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.learning.notification.from.learning.generic',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            ),
        )
    ),

    // lk: AccountManagement pull-jms, since #WHO-4433
    'AccountManagement' => array(
        'location' => array(
            'http://brWhotradesFR1.mq.finam.ru:2802/jms2http',
            'http://brWhotradesFR1-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'AccountProfit' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.trade_system.notification.profit.from.comon.AccountManagement',
                ),
                'auth' => array(
                    'login' => 'wt.trade_system',
                    'password' => 'FXigrNoVU'
                ),
            ),
            // lk: runtime pull-jms SINCE #WHO-3898
            'AccountPortfolio' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.trade_system.notification.portfolio.from.comon.AccountManagement',
                ),
                'auth' => array(
                    'login' => 'wt.trade_system',
                    'password' => 'FXigrNoVU'
                ),
            ),
        )
    ),

    'Crm' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'Asterisk' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.crm.notification.from.asterisk.generic',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            )
        )
    ),

    // ad: 3card #WTT-418
    'TriCard' => array(
        'location' => array(
            'http://brPayProcNY.mq.finam.ru:3402/jms2http',
            'http://brPayProcNY-back.mq.finam.ru:3402/jms2http',
        ),
        'timeout'  => 55,
        'queues' => array(
            'FinamWallet' => array(
                'headers' => array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.payments_processing.response.from.ibank.wallet',
                ),
                'auth' => array(
                    'login' => 'whotrade',
                    'password' => 'RXLvPxEPdK'
                )
            )
        )
    ),

    'NonExchangeOptions' => array(
        'location' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/jms2http',
            'http://brWhotradesNY-back.mq.finam.ru:2802/jms2http'
        ),
        'timeout'  => 55,
        'queues' => array(
            'Account' => array(
                'headers' =>  array(
                    'Content-Type' => 'text/xml; charset=UTF-8',
                    'X-JMS-Action' => 'pull-msg',
                    'X-JMS-Timeout' => 50000,
                    'X-JMS-ReceiveQueue' => 'wt.non_exchange_options.notification.from.neoptions.account',
                ),
                'auth' => array(
                    'login' => 'whotrades',
                    'password' => 'Ljcneg123'
                ),
            )
        )
    ),
);

// How many urls from ConnectionPool to check before stop checking process
$this->finamTenderSystem['services']['EnterpriseService']['tryUrls'] = 3;

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.IslandsRegistration.Async'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        // ag: brComon
        'url' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-DeliveryMode' => 'PERSISTENT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brComon::islands.learning',
            'X-JMS-User' => 'whotrades',
            'X-JMS-Password' => 'Ljcneg123',
        )
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brBOFMFR1::finam.BOFM.Clients',
            'X-JMS-User' => 'whotrade',
            'X-JMS-Password' => 'RXLvPxEPdK',
            'X-JMS-ReplyTo' => 'brESBFR1::wt.Receiver.from.BOLtd.Client.Create'
        )
    ),
    'timeout' => 3600
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Accounts'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brWhotradesNY.mq.finam.ru:2802/http2jms',
            'http://brWhotradesNY-back.mq.finam.ru:2802/http2jms',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brBOFMFR1::finam.BOFM.Accounts',
            'X-JMS-User' => 'whotrade',
            'X-JMS-Password' => 'RXLvPxEPdK',
            'X-JMS-ReplyTo' => 'brESBFR1::wt.Receiver.from.BOLtd.Client.Create'
        )
    ),
    'timeout' => 3600
);

// ad: 3card #WTT-418
$this->finamTenderSystem['services']['enterprise']['FinamWallet'] = array(
    'user' => 'dev',
    'password' => 'dev',
    'transport' => 'SonicMq.Msk.TriCard',
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.TriCard'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://brPayProcNY.mq.finam.ru:3402/http2jms',
            'http://brPayProcNY-back.mq.finam.ru:3402/http2jms',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'xml',
            'X-JMS-User' => 'whotrade',
            'X-JMS-Password' => 'RXLvPxEPdK',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brIBank::finam.bank.wallet.prod.request',
            'X-JMS-ReplyTo' => 'brPayProcNY::wt.payments_processing.response.from.ibank.wallet',
            'X-JMS-Type' => 'CreateWalletRequest' // ad: can be also PaymentRequest
        )
    ),
    'timeout' => 10
);

// ad: Etna #WTI-178
$this->finamTenderSystem['services']['enterprise']['Etna'] = array(
    'transport' => 'Http.Finam.Etna'
);

$this->finamTenderSystem['services']['enterprise']['BackOfficeClientCreate'] = array(
    'documentsMultiFiles' => false,
);

// last line!!! last line!!! last line!!! last line!!! last line!!! last line!!!