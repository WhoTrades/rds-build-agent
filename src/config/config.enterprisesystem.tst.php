<?php
// vdm: Файл с настройками ES для работы test-контура проекта WT. Возможно что его переименуем в dev т.к. он смотрит на стабильную-версию ES-сервисов
$this->finamTenderSystem['services']['enterprise']['transport']['Http.Finam.OpenInviter']['config']['url'] = "http://openinviter.finam.ru/exp4mail.php";

$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Informations']['config']['url'] = 'https://msk-webapp1.office.finam.ru/BackOffice/Informations';
$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Informations.Slow']['config']['url'] = 'https://msk-webapp1.office.finam.ru/BackOffice/Informations';
//lk: bo real account profit on dev. #WHO-1019
$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports']['config']['url'] = 'https://msk-webapp1.office.finam.ru/BackOffice/Reports';
$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports.Slow']['config']['url'] = 'https://msk-webapp1.office.finam.ru/BackOffice/Reports';

$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports.ClientAssistanceCommission.AccountsLinkCreate']['config']['url'] = 'https://bofm-test.office.finam.ru/BackOffice/Reports';
$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports.ClientAssistanceCommission.CommissionByAgent']['config']['url'] = 'https://bofm-test.office.finam.ru/BackOffice/Reports';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.Maccessor.Msk.TransaqDev1'] = array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'finam.maccessor.wtdev',
                'X-JMS-User' => 'dev',
                'X-JMS-Password' => 'dev',
                'X-JMS-Type' => 'SOAP'
            )
        ),
        'timeout' => 10
    );

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ComonRu.Mobile']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ComonRu.Mobile']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ComonRu.Mobile']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ComonRu.Mobile']['timeout'] = 5; // vdm: уменьшил время запроса, т.к. новая торговалка быстро отваливалась по таймауту

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.Account']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.Account']['config']['headers']['X-JMS-DestinationQueue'] = 'brWhotrade::dev.app.Option.AccountBind';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.Account']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.Account']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.Account']['config']['headers']['X-JMS-Type'] = 'SOAP';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.PaymentsProcessing']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:2509/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.PaymentsProcessing']['config']['headers']['X-JMS-DestinationQueue'] = 'brWhotrade::dev.app.Option.MoneyRecive';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.PaymentsProcessing']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.PaymentsProcessing']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.ExoticOptions.PaymentsProcessing']['config']['headers']['X-JMS-Type'] = 'SOAP';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['url'] = array(
    'brWhotradesNY.mqtst.finam.ru:2802/http2jms',
    'brWhotradesNY-back.mqtst.finam.ru:2802/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['location'] = array(
    'brWhotradesNY.mqtst.finam.ru:2802/http2jms',
    'brWhotradesNY-back.mqtst.finam.ru:2802/http2jms'
);
$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['queues']['Account']['auth']['login'] = 'dev';
$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['queues']['Account']['auth']['password'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.Transaq.Msk.TransaqDev1'] = array(
        'class' => '\WtTransport\SonicMq',
        'config' => array(
            'url' => array(
                'http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms.sync'
            ),
            'headers' => array(
                'X-JMS-MessageType' => 'TEXT',
                'X-JMS-Action' => 'push-msg',
                'X-JMS-DestinationQueue' => 'dev.Whotrade.Transaq.dev1',
                'X-JMS-User' => 'dev',
                'X-JMS-Password' => 'dev',
                'X-JMS-Type' => 'SOAP',
                'finam_ComputerName' => 'DEV',
                'finam_AppName' => 'WT-EnterpriseService-Transaq.Msk.TransaqDev1',
            )
        ),
        'timeout' => 10
    );

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.Uchetka.Msk.TransaqDev1'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms.sync'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'dev.Whotrade.Portfolio.dev1',
            'X-JMS-User' => 'dev',
            'X-JMS-Password' => 'dev',
            'X-JMS-Type' => 'SOAP',
            'finam_ComputerName' => 'DEV',
            'finam_AppName' => 'WT-EnterpriseService-Uchetka.Msk.TransaqDev1',
        )
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.Transaq.Msk.Transaq3'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms.sync'
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brMsg::finam.Transaq.Fight.En',
            'X-JMS-User' => 'dev',
            'X-JMS-Password' => 'dev',
            'X-JMS-Type' => 'SOAP',
            'finam_ComputerName' => 'DEV',
            'finam_AppName' => 'WT-EnterpriseService-Transaq.Msk.Transaq3',
        )
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Create']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Create']['config']['headers']['X-JMS-DestinationQueue'] = 'brESB::IMClient.Create';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Create']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Create']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.Update';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.BugReport']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.BugReport']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.wt.Notification.BOLtd';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.BugReport']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.BugReport']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.Update';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.TradeAccount.Create';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Rdss']['config']['url'] = array('http://msk-mq1.office.finam.ru:3510/http2jms_Sync60', 'http://msa-mq2.office.finam.ru:3510/http2jms_Sync60');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Rdss']['config']['headers']['X-JMS-DestinationQueue'] = 'brQuotes::finam.Reuters.RDSS';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Subscription']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Subscription']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.wt.Notification.BOLtd';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Subscription']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Subscription']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.PaymentsProcessing']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.PaymentsProcessing']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.wt.Notification.BOLtd';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.PaymentsProcessing']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.PaymentsProcessing']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['Http.Webinar.PaymentsProcessing']['config']['url'] = array('http://stage.finam.ru/scripts/payments/default.asp?name=whotrade');


$this->finamTenderSystem['services']['enterprise']['GenericPaymentsProcessing'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['salt'] = 'tD4576m2zsXoR';
$this->finamTenderSystem['services']['enterprise']['GenericPaymentsProcessing'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL_SYC]['salt'] = 'tD4576m2zsXoR';
$this->finamTenderSystem['services']['enterprise']['transport']['Http.ExternalFl.PaymentsProcessing']['config']['url'] = 'http://finameumain.msa-webtest1.finam.ru/api/UpdatePayment/';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.PaymentsProcessing']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.PaymentsProcessing']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.PaymentsProcessing']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.Order.Create';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms_Sync60',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms_Sync60'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Sync']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Sync']['config']['headers']['X-JMS-DestinationQueue'] = 'comon.strategies.request.wtdev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Sync']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Sync']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Async']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Async']['config']['headers']['X-JMS-DestinationQueue'] = 'comon.strategies.request.wtdev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Async']['config']['headers']['X-JMS-ReplyTo'] = 'comon.strategies.response.wtdev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.SignalRepeater.Async']['config']['headers']['X-JMS-User'] = 'dev';

// lk: AccountManagement #WHO-2797
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Sync']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Sync']['config']['headers']['X-JMS-DestinationQueue'] = 'comon.bo.request';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Sync']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Sync']['config']['headers']['X-JMS-User'] = 'dev';

// lk: SonicMq.AccountManagement.Async dev config
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Async']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Async']['config']['headers']['X-JMS-DestinationQueue'] = 'comon.bo.request';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.AccountManagement.Async']['config']['headers']['X-JMS-User'] = 'dev';

// lk: TradesHistory #WHO-1827
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradesHistory.Sync']['config']['url'] = array('http://brComon.mqdev.finam.ru:2602/http2jms_Sync60');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradesHistory.Sync']['config']['headers']['X-JMS-DestinationQueue'] = 'tradesHistory.request';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradesHistory.Sync']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradesHistory.Sync']['config']['headers']['X-JMS-User'] = 'dev';

// lk: TradeRepeater push-jms #WHO-3737
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['url'] = array('http://brWhotrades.mqdev.finam.ru:2802/http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['headers']['X-JMS-DestinationQueue'] = 'brAutoFollowing::venturefx.qa.commands';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['headers']['X-JMS-User'] = 'dev';

// lk: BackOffice.AccountMoneyTransfer push-jms #WHO-340
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.AccountMoneyTransfer.Async']['config']['url'] = array(
    'http://msk-tstsonic1.office.finam.ru:12102/http2jms',
    'http://msa-tstsonic2.office.finam.ru:12102/http2jms'
);
// lk: at tst broker brWhotradesNY (same as prod) since #WTI-362
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.AccountMoneyTransfer.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.AccountMoneyTransfer.Async']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['url'] =
array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms_Sync60',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms_Sync60'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.TradeTransactions']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.TradeTransactions']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.wt.Notification.BOLtd';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.TradeTransactions']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.TradeTransactions']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.ClientChange']['config']['url'] = "https://msk-webapp1.office.finam.ru/BackOffice/Client";

// SonicMq.MetaTrader.MD1
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD1']['config']['url'] = array(
    'http://msk-mq1.office.finam.ru:3510/http2jms_Sync60',
    'http://msa-mq2.office.finam.ru:3510/http2jms_Sync60',
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD1']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD1']['config']['headers']['X-JMS-Password'] = 'dev';

// SonicMq.MetaTrader.MD2
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD2']['config']['url'] = array(
    'http://msk-mq1.office.finam.ru:3510/http2jms_Sync60',
    'http://msa-mq2.office.finam.ru:3510/http2jms_Sync60',
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD2']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MD2']['config']['headers']['X-JMS-Password'] = 'dev';

// ag: Remove SonicMq.MetaTrader.MR1 and SonicMq.MetaTrader.MR2 sections as redundant. Since #WTI-73

/**
 * lk: MetaTrader demo transport
 * @see http://it-portal/tasks/browse/APP-4308?page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel
 */
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.ForexTestSR'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://msk-mq1.office.finam.ru:3510/http2jms_Sync60',
            'http://msa-mq2.office.finam.ru:3510/http2jms_Sync60',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brTrade::finam.MT4.Test.FinamGate',
            'X-JMS-User' => 'dev',
            'X-JMS-Password' => 'dev'
        ),
    ),
    'timeout' => 10
);
/**
 * lk: MetaTrader test transport
 * @see http://it-portal/tasks/browse/APP-4308?page=com.atlassian.jira.plugin.system.issuetabpanels:comment-tabpanel
 */
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MetaTrader.MTT'] = array(
    'class' => '\WtTransport\SonicMq',
    'config' => array(
        'url' => array(
            'http://msk-mq1.office.finam.ru:3510/http2jms_Sync60',
            'http://msa-mq2.office.finam.ru:3510/http2jms_Sync60',
        ),
        'headers' => array(
            'X-JMS-MessageType' => 'TEXT',
            'X-JMS-Action' => 'push-msg',
            'X-JMS-DestinationQueue' => 'brMsg::dev.MT4.Test',
            'X-JMS-User' => 'dev',
            'X-JMS-Password' => 'dev'
        ),
    ),
    'timeout' => 10
);

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmOffices.Sync']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms.sync');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmOffices.Sync']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmOffices.Sync']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmWebForm.Async']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmWebForm.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.MsCrmWebForm.Async']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Response.Async']['config']['url'] = array(
    'http://msa-tstsonic2.office.finam.ru:12102/http2jms',
    'http://msk-tstsonic1.office.finam.ru:12102/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Response.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Response.Async']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.NonTradeOrder.Async']['config']['url'] = array(
    'http://brWhotradesNY.mqtst.finam.ru:2802/http2jms',
    'http://brWhotradesNY-back.mqtst.finam.ru:2802/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.NonTradeOrder.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.NonTradeOrder.Async']['config']['headers']['X-JMS-User'] = 'dev';

/*********************************** SERVICE ***********************************/

//lk: MetaTraderDemo
$this->finamTenderSystem['services']['enterprise']['ForexTestSR'] = array(
    'MetaTrader' => array(
        'user' => '???',
        'password' => '???',
        'pluginPassword' => null, // vdm: no ability to change money
        'transport' => 'SonicMq.MetaTrader.ForexTestSR',
        'metatraderClientGroups' => array(),
    )
);
//lk: MetaTraderTest
$this->finamTenderSystem['services']['enterprise']['MTT'] = array(
    'MetaTrader' => array(
        'user' => '???',
        'password' => '???',
        'pluginPassword' => null, // vdm: no ability to change money
        'transport' => 'SonicMq.MetaTrader.MTT',
        'metatraderClientGroups' => array()
    )
);

$this->finamTenderSystem['services']['enterprise']['Msk.TransaqDev1.Nysdaq'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transaqServerName' => 'msk-transaqdev1',
    'transport' => 'SonicMq.Msk.Maccessor.Msk.TransaqDev1',
    'transportTransaq' => 'SonicMq.Msk.Transaq.Msk.TransaqDev1',
    'transportUchetka' => 'SonicMq.Msk.Uchetka.Msk.TransaqDev1',
    'transportTransaqSync' => 'Soap.TransaqSync'
);
$this->finamTenderSystem['services']['enterprise']['Msk.TransaqDev1.Xetra'] = array(
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transaqServerName' => 'msk-transaqdev1',
    'transport' => 'SonicMq.Msk.Maccessor.Msk.TransaqDev1',
    'transportTransaq' => 'SonicMq.Msk.Transaq.Msk.TransaqDev1',
    'transportUchetka' => 'SonicMq.Msk.Uchetka.Msk.TransaqDev1',
    'transportTransaqSync' => 'Soap.TransaqSync'
);
$this->finamTenderSystem['services']['enterprise']['Msk.Transaq3'] = array( // TODO: -> Fra.Transaq1
    'user' => 'whotrade',
    'password' => 'whotrade',
    'transport' => null,
    'transportTransaq' => 'SonicMq.Msk.Transaq.Msk.Transaq3' // TODO: -> SonicMq.Transaq.Fra.Transaq1
);

$this->finamTenderSystem['services']['enterprise']['xetra-demo']['Transaq'] = 'Msk.TransaqDev1.Xetra';


$this->finamTenderSystem['services']['enterprise']['nysdaq-demo']['Transaq'] = 'Msk.TransaqDev1.Nysdaq';


//lk: on dev/tst real forex accounts created on MD2 instead of MR1
$this->finamTenderSystem['services']['enterprise']['forex-real']['Metatrader'] = 'MD2';

$this->finamTenderSystem['TradeSystemNames']['map']['forex-real'] = 'MD2'; // ??? sl: change from MR1
$this->finamTenderSystem['TradeSystemNames']['map']['forex-real-mr2'] = 'MD2';
$this->finamTenderSystem['TradeSystemNames']['map']['forex-real-mr3'] = 'MD2';

//lk: fix transaq to msk-transaqdev1.office.finam.ru for dev environment, since #WHO-1827. see http://it-portal/wiki/display/tradesystems/Trade+System+Name
$this->finamTenderSystem['TradeSystemNames']['map']['xetra-demo'] = 'TDD1'; //change from TDFF1
$this->finamTenderSystem['TradeSystemNames']['map']['nysdaq-demo'] = 'TDD1'; //change from TDFU1
//lk signal repeater slave account at dev/tst env, since #WHO-4433
$this->finamTenderSystem['TradeSystemNames']['map']['forex-slave'] = 'ForexTestSR'; //change from MD1

// vdm: ��, ������ ��� ��������. ���� ��� �����, �������� ������� � ������ �����
$this->finamTenderSystem['services']['enterprise']['BackOfficeClq'] = array(

);

// lk: switched from http://msa-tstsonic2.office.finam.ru:8102/http2jms #WTI-359
$this->finamTenderSystem['services']['EnterpriseService']['devWt']['location'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/jms2http',
    'http://brESBFR1-back.mqtst.finam.ru:2302/jms2http'
);
$this->finamTenderSystem['services']['EnterpriseService']['devWt']['queues']['BO']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['devWt']['queues']['BPM']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

// lk: switched from http://msa-tstsonic2.office.finam.ru:8102/http2jms #WTI-359
$this->finamTenderSystem['services']['EnterpriseService']['bpm']['location'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/jms2http',
    'http://brESBFR1-back.mqtst.finam.ru:2302/jms2http'
);
$this->finamTenderSystem['services']['EnterpriseService']['bpm']['queues']['DocumentRequest']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);


$this->finamTenderSystem['services']['EnterpriseService']['signalRepeater']['location'] = 'http://msk-mqesb1.office.finam.ru:3610/dev.wt.jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['signalRepeater']['queues']['SubscribeRequest']['headers']['X-JMS-ReceiveQueue'] = 'comon.strategies.response.wtdev';
$this->finamTenderSystem['services']['EnterpriseService']['signalRepeater']['queues']['SubscribeRequest']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['signalRepeater']['queues']['ProfitStrategy']['headers']['X-JMS-ReceiveQueue'] = 'comon.strategies.profit.response.wtdev';
$this->finamTenderSystem['services']['EnterpriseService']['signalRepeater']['queues']['ProfitStrategy']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

//warl: Learning pull JMS. since #WTS-133
$this->finamTenderSystem['services']['EnterpriseService']['Learning']['location'] = 'http://brWhotradesNY.mqdev.finam.ru:3122/jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['Learning']['queues']['Callback']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

//lk: TradesHistory pull JMS. since #WHO-1827
$this->finamTenderSystem['services']['EnterpriseService']['TradesHistory']['location'] = 'http://brWhotrades.mqdev.finam.ru:2802/jms2http';
//lk: queue name the same as prod
// $this->finamTenderSystem['services']['EnterpriseService']['TradesHistory']['queues']['TradeTransaction']['headers']['X-JMS-ReceiveQueue'] = 'wt.trade_system.notification.from.comon.TradesHistory';
$this->finamTenderSystem['services']['EnterpriseService']['TradesHistory']['queues']['TradeTransaction']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

//lk: TradeRepeater pull-jms. since #WHO-3737. queue name the same as prod
$this->finamTenderSystem['services']['EnterpriseService']['TradeRepeater']['location'] = 'http://brWhotrades.mqdev.finam.ru:2802/jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['TradeRepeater']['queues']['CommandResult']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
//lk: since WHO-3898
$this->finamTenderSystem['services']['EnterpriseService']['TradeRepeater']['queues']['PortfolioSnapshot']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

//lk: AccountManagement pull-jms. since #WHO-4433. queue name the same as prod
$this->finamTenderSystem['services']['EnterpriseService']['AccountManagement']['location'] = 'http://brWhotrades.mqdev.finam.ru:2802/jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['AccountManagement']['queues']['AccountProfit']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['AccountManagement']['queues']['AccountPortfolio']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

//lk: ProfitStreamer pull-jms. since #WHO-3737. queue name the same as prod
$this->finamTenderSystem['services']['EnterpriseService']['ProfitStreamer']['location'] = 'http://brWhotrades.mqdev.finam.ru:2802/jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['ProfitStreamer']['queues']['AccountProfitIntraday']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

// ag: Section for SMS. Since #WTI-125
$this->finamTenderSystem['services']['EnterpriseService']['Sms']['location'] = array(
        'http://msk-tstsonic1.office.finam.ru:12102/jms2http',
        'http://msa-tstsonic2.office.finam.ru:12102/jms2http'
);
$this->finamTenderSystem['services']['EnterpriseService']['Sms']['queues']['Generic']['auth'] = array(
        'login' => 'dev',
        'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['Sms']['queues']['Send']['auth'] = array(
        'login' => 'dev',
        'password' => 'dev'
);

//lk: BackOffice pull-jms. since #WTT-340. queue name the same as prod
//lk: broker brWhotradesNY #WTI-362
$this->finamTenderSystem['services']['EnterpriseService']['BackOffice']['location'] = array(
    'http://brWhotradesNY.mqtst.finam.ru:2802/jms2http',
    'http://brWhotradesNY-back.mqtst.finam.ru:2802/jms2http',
);
$this->finamTenderSystem['services']['EnterpriseService']['BackOffice']['queues']['Remittance']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['BackOffice']['queues']['PersonInfo']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['BackOffice']['queues']['ContactCheck']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['BackOffice']['queues']['NonTradeOrder']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);


$this->finamTenderSystem['services']['EnterpriseService']['brWhotrades']['location'] = array(
    'http://msk-tstsonic1.office.finam.ru:12102/jms2http',
    'http://msa-tstsonic2.office.finam.ru:12102/jms2http'
);
$this->finamTenderSystem['services']['EnterpriseService']['brWhotrades']['queues']['FinamFx']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['brWhotrades']['queues']['MtArchived']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

// lk: switched from http://msa-tstsonic2.office.finam.ru:8102/http2jms #WTI-359
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['location'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/jms2http',
    'http://brESBFR1-back.mqtst.finam.ru:2302/jms2http'
);
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOClientCreate']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOClientChange']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOAgentCreate']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOAgentDelete']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOOrderStatusChange']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

// ag: brComon
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.IslandsRegistration.Async']['config']['url'] = array('http://msk-tstsonic1.office.finam.ru:11102/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.IslandsRegistration.Async']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.IslandsRegistration.Async']['config']['headers']['X-JMS-User'] = 'dev';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Accounts']['config']['url'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Accounts']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Accounts']['config']['headers']['X-JMS-User'] = 'dev';

// lk: TODO: not used now, kill 21/08/2014
$this->finamTenderSystem['services']['EnterpriseService']['Crm']['location'] = array(
    'http://brESBFR1.mqtst.finam.ru:2302/http2jms',
    'http://brESBFR1-back.mqtst.finam.ru:2302/http2jms'
);
$this->finamTenderSystem['services']['EnterpriseService']['Crm']['queues']['Asterisk']['auth'] = array(
    'login' => 'dev',
    'password' => 'dev'
);

// ad: 3card #WTT-418
$this->finamTenderSystem['services']['EnterpriseService']['TriCard']['location'] = array(
    'http://msk-tstsonic1.office.finam.ru:14102/jms2http',
    'http://msa-tstsonic2.office.finam.ru:14102/jms2http',
);
$this->finamTenderSystem['services']['EnterpriseService']['TriCard']['queues']['FinamWallet']['auth']['login'] = 'dev';
$this->finamTenderSystem['services']['EnterpriseService']['TriCard']['queues']['FinamWallet']['auth']['password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['FinamWallet']['user'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['FinamWallet']['password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.TriCard']['config']['url'] = array(
    'http://msk-tstsonic1.office.finam.ru:14102/http2jms',
    'http://msa-tstsonic2.office.finam.ru:14102/http2jms',
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.TriCard']['config']['headers']['X-JMS-User'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.TriCard']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Msk.TriCard']['config']['headers']['X-JMS-DestinationQueue'] = 'brIBank::finam.bank.wallet.uat.request';

// ad: Etna #WTI-178
// lk: separated uat-server since 14/08/2014
$this->finamTenderSystem['services']['enterprise']['transport']['Http.Finam.Etna']['config']['url'] = 'http://nye-trade04-q.whotrades.local:7008/UserManagementWebService';

$this->finamTenderSystem['services']['enterprise']['BackOfficeClientCreate']['documentsMultiFiles'] = true;

//last line