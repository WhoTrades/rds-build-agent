<?php
// TODO: @tst should be openinviter.finam.ru
$this->finamTenderSystem['services']['enterprise']['transport']['Http.Finam.OpenInviter']['config']['url'] = "http://openinviter.{$tld}.whotrades.net/exp4mail.php";

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Create']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Questionnaire.Update']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');

// ag: Send to tst for BO
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.BugReport']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.TradeAccounAdd']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.TradeAccount.Add';

// ag: Send to tst for BO
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Subscription']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');

// ag: Send to tst for BO
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.PaymentsProcessing']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.PaymentsProcessing']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.PaymentsProcessing']['config']['headers']['X-JMS-DestinationQueue'] = 'IMClient.Create.TransactionMoneyIn';

//lk Learining
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Learning.PaymentsProcessing']['config']['url'] = array('http://brWhotrades.mqdev.finam.ru:2802/http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Learning.PaymentsProcessing']['config']['headers']['X-JMS-DestinationQueue'] = 'brWhotrades::dist.learning.payments';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Learning.PaymentsProcessing']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Learning.PaymentsProcessing']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['enterprise']['GenericPaymentsProcessing'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL]['salt'] = 'tD4576m2zsXoR';
$this->finamTenderSystem['services']['enterprise']['GenericPaymentsProcessing'][\PaymentsProcessingSystem\Recipients::EXTERNAL_FL_SYC]['salt'] = 'tD4576m2zsXoR';
$this->finamTenderSystem['services']['enterprise']['transport']['Http.ExternalFl.PaymentsProcessing']['config']['url'] = 'http://finameumain.msa-webtest1.finam.ru/api/UpdatePayment/';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Assignment']['config']['headers']['X-JMS-DestinationQueue'] = 'bpm.IMClient.Order';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.bpm.Messages';


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['headers']['X-JMS-DestinationQueue'] = 'finam.bpm.Messages';

// lk: TradeRepeater push-jms dev
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['url'] = array('http://brWhotrades.mqdev.finam.ru:2802/http2jms');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.TradeRepeater.Async']['config']['headers']['X-JMS-DestinationQueue'] = 'brAutoFollowing::venturefx.dev.commands';

// ag: Send to tst for BO
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.TradeTransactions']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms');

$this->finamTenderSystem['services']['EnterpriseService']['devWt']['location'] = 'http://msk-mqesb1.office.finam.ru:3510/dev.wt.jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['devWt']['queues']['BPM']['headers']['X-JMS-ReceiveQueue'] = 'bpm.IMClient.Notify.wt';


$this->finamTenderSystem['services']['EnterpriseService']['bpm']['location'] = 'http://msk-mqesb1.office.finam.ru:3510/dev.wt.jms2http';


$this->finamTenderSystem['services']['EnterpriseService']['Wt']['location'] = 'http://msk-mqesb1.office.finam.ru:3510/dev.wt.jms2http';
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOClientCreate']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.Receiver.from.BOLtd.Client.Create';
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOClientChange']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.Receiver.from.BOLtd.Client.Change';
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOAgentCreate']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.Receiver.from.BOLtd.Agent.Create';
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOAgentDelete']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.Receiver.from.BOLtd.Agent.Delete';
$this->finamTenderSystem['services']['EnterpriseService']['Wt']['queues']['BOOrderStatusChange']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.Receiver.from.BOLtd.Order.Status.Change';

// lk: TradeRepeater pull-jms dev
$this->finamTenderSystem['services']['EnterpriseService']['TradeRepeater']['queues']['CommandResult']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.trade_repeater.notification.from.VentureFX';
$this->finamTenderSystem['services']['EnterpriseService']['TradeRepeater']['queues']['PortfolioSnapshot']['headers']['X-JMS-ReceiveQueue'] = 'dev.wt.trade_repeater.notification.portfolio.from.VentureFX';

$this->finamTenderSystem['services']['EnterpriseService']['brWhotrades']['location'] = array(
    'http://brWhotrades.mqdev.finam.ru:2802/jms2http',
);

// ag: brComon
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.IslandsRegistration.Async']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3610/dev.wt.http2jms');

//sl: отправляем пакеты о новом клиенте на test
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients']['config']['url'] = array('http://msk-mqesb1.office.finam.ru:3510/dev.wt.http2jms.sync');
//$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.BackOffice.Clients']['config']['headers']['X-JMS-DestinationQueue'] = 'brBOLtd::finam.BOFM.Clients';

//$this->finamTenderSystem['services']['EnterpriseService']['brWhotrades']['location'] = 'http://brWhotrades.mqdev.finam.ru:2802/jms2http';

$this->finamTenderSystem['services']['EnterpriseService']['Crm']['queues']['Asterisk']['headers']['X-JMS-ReceiveQueue'] = 'wt.Receiver.from.BOLtd.Agent.Create';
$this->finamTenderSystem['services']['EnterpriseService']['Crm']['location'] = array(
    'http://msk-mqesb1.office.finam.ru:3510/dev.wt.jms2http',
);
$this->finamTenderSystem['services']['enterprise']['BackOfficeClientCreate']['documentsMultiFiles'] = true;

// lk: ETNA #WTI-178
$this->finamTenderSystem['services']['enterprise']['transport']['Http.Finam.Etna']['config']['url'] = 'http://msa-devetn-oms1.office.finam.ru:8006/UserManagementWebService';

$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['url'] = array(
    'brWhotradesNY.mqdev.finam.ru:2802/http2jms'
);
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['headers']['X-JMS-Password'] = 'dev';
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.NonExchangeOptions.Account']['config']['headers']['X-JMS-User'] = 'dev';

$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['location'] = array(
    'brWhotradesNY.mqdev.finam.ru:2802/http2jms'
);
$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['queues']['Account']['auth']['login'] = 'dev';
$this->finamTenderSystem['services']['EnterpriseService']['NonExchangeOptions']['queues']['Account']['auth']['password'] = 'dev';


//last line

