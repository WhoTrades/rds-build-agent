<?php
// vdm: Файл с настройками ES для работы preprod-контура проекта WT. Возможно что его переименуем в tst т.к. он смотрит на очень-очень стабильную версию ES-сервисов (чехарда с именами до появления qa-контура)


$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Check']['config']['url'] = array('http://brESB.mqpp.finam.ru:2302/http2jms_Sync60');
$this->finamTenderSystem['services']['enterprise']['transport']['SonicMq.Bpm.Messages.Send']['config']['url'] = array('http://brESB.mqpp.finam.ru:2302/http2jms_Sync60');
$this->finamTenderSystem['services']['EnterpriseService']['bpm']['location'] = 'http://brESB.mqpp.finam.ru:2302/http2jms';

$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports.ClientAssistanceCommission.AccountsLinkCreate']['config']['url'] = 'https://bofm-pp.office.finam.ru/BackOffice/Reports';
$this->finamTenderSystem['services']['enterprise']['transport']['Soap.BackOffice.Reports.ClientAssistanceCommission.CommissionByAgent']['config']['url'] = 'https://bofm-pp.office.finam.ru/BackOffice/Reports';

// ag: Set url after create brWhotradesNY on pre-prod
/*
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
*/


//last line