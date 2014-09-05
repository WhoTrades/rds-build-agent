<?php

use \WtConsts\PaySystems;
use \PaymentsProcessingSystem\Recipients;
use \PaymentsProcessingSystem\Conversion\AccountsTypes;

$this->paymentsProcessingSystem['debug_mode'] = 0;

$this->paymentsProcessingSystem['DSN_PAYMENTS'] = $this->DSN_DB3;
$this->paymentsProcessingSystem['DSN_WT_WALLET'] = $this->DSN_DB3;

$this->paymentsProcessingSystem['api'] = array(
    'command' => 'http://api.whotrades.com/api/payments-processing/command/',
    'system' => 'http://api.whotrades.com/api/payments-processing/system/',
);

// ad: history of currency rates #WTI-244
$this->paymentsProcessingSystem['currencyRates'] = array(
    'refreshRate' => 1, // min
    'historyDepth' => 30, // number of last rates to store
    'maxActualAge' => 2, // maximum age of rate to be still actual
);

$this->paymentsProcessingSystem['paypal'] = array(
    'enabled' => false, // Перед включением ПС необходимо убедиться в актуальности кода обработчиков

    'currency' => array('USD', 'EUR'), // access list: https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),
    'url' => 'https://www.paypal.com/cgi-bin/webscr',
    'business' => 'Zhilin@finam.ru',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/paypal/',
        'notify_validate_url' => 'https://www.paypal.com/cgi-bin/webscr',
        'timeout' => 30
    ),

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => 100000
);

// vdm: callback url задается письмом Kostylev_af@masterbank.ru: http://api.whotrades.com/api/payments-processing/masterbank/
$this->paymentsProcessingSystem['masterbank'] = array(
    'enabled' => true,

    'currency' => array('RUB', 'USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB'),
    'url' => 'https://web3ds.masterbank.ru/cgi-bin/cgi_link',
    'api_url' => 'https://web3ds.masterbank.ru/cgi-bin/cgi_link',

    'merchant_name' => 'Whotrades Ltd',

    'terminal' => '71846117',
    'country' => 'US',
    'merchant' => '710000000846117',

    'details_api_uri'=>'https://elcom.masterbank.ru/cgi-bin/elcom_extract',

    'cert_file' => dirname(__FILE__) . '/../misc/thirdparty/masterbank/71846117.pem',

    'cert_file_pass' => 'q1w2e3',

    /*
    'ip_access_list' => array(
        '195.96.164.107',
        '195.96.164.22'
    ),*/

    'merchant_url' => 'https://whotrades.com/payments/result/generic',
    'generic_url' => 'https://whotrades.com/payments/result/generic',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 3000,
        'EUR' => 2000,
        'RUB' => 100000
    ),

    'paymentNote' => 'payment_universal_note_masterbank',
    'paymentNoteCommissionHardcoded' => true,
);

// vdm: callback url управляется через админку на secure.payonlinesystem.com: http://api.whotrades.com/api/payments-processing/payonline/
$this->paymentsProcessingSystem['payonline'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR', 'RUB'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB'),
    'url' => 'https://secure.payonlinesystem.com/en/payment/Finam/',
    'merchant' => 7018,
    'securityKey' => 'ee5c39eb-ae4b-4c6d-91f8-8436e5c77e0c',
    'lcid2UrlMap' => array(
        'ru' => 'https://secure.payonlinesystem.com/ru/payment/Finam/',
    ),

    'return_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',

    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 3000,
        'EUR' => 2000,
        'RUB' => 100000
    ),

    'paymentNote' => 'payment_universal_note_payonline',
    'paymentNoteCommissionHardcoded' => true,
    'withoutMin' => true,
);

//http://api.whotrades.com/api/payments-processing/moneybookers/
$this->paymentsProcessingSystem['moneybookers'] = array(
    'enabled' => true,

    'url' => 'https://www.moneybookers.com/app/payment.pl',
    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),
    'languages' => array('EN', 'DE', 'ES', 'FR', 'IT', 'PL', 'GR', 'RO', 'RU', 'TR', 'CN', 'CZ', 'NL', 'DA', 'SV', 'FI'),
    'language_default' => 'EN',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/moneybookers/',
    ),

    'return_url' => 'http://whotrades.com/payments/result/success',
    'fail_url' => 'http://whotrades.com/payments/result/cancel',
    'logo_url' => 'http://static.whotrades.com/images/comon/logo_04.png',

    'rid' => '30495125',
    'merchant_name' => 'WHOTRADES',
    'pay_to_email' => 'info@whotrades.eu',
    'securityKey' => '88150D7D17390010BA6222DE68BFAFB5', //strtoupper(md5('everybody'))

    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 5000,
        'EUR' => 5000,
        'RUB' => 150000
    ),

    'paymentNote' => 'payment_universal_note_moneybookers',
    'paymentNoteCommissionHardcoded' => true,
);

// warl: callback url управляется через админку на https://ishop.qiwi.ru/protocolSOAP.action: http://api.whotrades.com/api/payments-processing/qiwi/
/**
 * Support:
 * A.Grigoryants@qiwi.ru
 * Artem Grigoryants
 * +7 909 9545539
 * Skype: artyom.qiwi
 *
 * support.psp@qiwi.com
 */
$this->paymentsProcessingSystem['qiwi'] = array(
    'enabled' => true,

    'api_url' => 'http://ishop.qiwi.ru/xml',
    'currency' => array('RUB', 'USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB'),
    'terminal_id' => '206179',
    'password' => 'aecl3xmht',

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 450,
        'EUR' => 350,
        'RUB' => 15000
    ),

    'sms_verify_form' => false,

    'coef_for_crediting' => 0.98, // ad: #WTT-454
    'coef_conversion_fee' => 0.985, // ad: #WHO-5020

    'ltime' => 60,  // время действия счёта в минутах

    'paymentNote' => 'payment_universal_note_qiwi_wallet',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

$this->paymentsProcessingSystem['algocharge'] = array(
    'enabled' => false,

    'currency' => array('USD', 'EUR', 'CNY'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'CNY' => 'CNY'),
    'url' => 'https://secure.algocharge.com/Webi/html/interface.aspx', // said to be better than https://incharge.allcharge.com/Webi/html/interface.aspx

    'merchant' => 2847564,
    'merchantName' => 'Algo',

    'password' => 'M1tM4r',

    // urls of status pages
    'return_url' => '',
    'return_url_wt_trader' => 'https://whotrades.com/cabinet/payments/%invoice_id%/status/?command=status',
    'return_url_wt_person' => 'https://whotrades.com/payments/%invoice_id%/status/?command=status',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',

    'api_url' => 'https://incharge.allcharge.com/Verify/VerifyNotification.aspx', // to verify back info posted to callback
    'api_url_sync' => 'https://incharge.allcharge.com/mi/html/synchronize.aspx ', // to verify synchronously info in handler

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'CNY' => 600
    ),
    'max' => array(
        'USD' => 10000,
        'EUR' => 10000,
        'CNY' => 60000
    ),

    'paymentNote' => 'payment_universal_note_algocharge',
);

//warl: callback url управляется через email на eug@pillonet.com: http://api.whotrades.com/api/payments-processing/astech/
$this->paymentsProcessingSystem['astech'] = array(
    'enabled' => true,
    'currency' => array('USD', 'CNY'),
    'currencyMap' => array('USD' => 'USD', 'CNY' => 'CNY'),

    'payments_systems' => array(
        'UKASH' => PaySystems::UKASH,
        'CREDIT' => PaySystems::CHINA_UNION_PAY,
        'CASHU_EWALLET' => PaySystems::CASHU
    ),

    'merchant_id' => 'WHOT000262',
    'merchant_name' => 'WHOTRADES',

    'store_id' => array(
        'china-union-pay' => 'WhoTradesLtd',
        'cashu' => 'WhoTradesCashU',
        'ukash' => 'WhoTradesSync'
    ),

    'brand_id' => 'T924T_WHOTASrm1',

    'url' => 'https://www.astechprocessing.net/ASTECH/Payments/ASTECHPayments.aspx',
    'url_mobile' => 'https://www.astechprocessing.net/ASTECH/Payments/MobilePayments.aspx',
    'api_url_sync' => array(
        'china-union-pay' => 'https://www.astechprocessing.net/ASTECH/WebService/AstechWebService.asmx/CreditOrderStatus',
        'cashu' => 'https://www.astechprocessing.net/ASTECH/WebService/AstechWebService.asmx/PaymentsOrderStatus'
    ),
    'api_password' => 'acsy1194AC',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    //warl: since #WHO-3470
    //комиссий за конвертацию не брать никаких
    'coef_conversion_fee' => 0.99,

    'securityKey' => 'qnp123%$1pgd29183nmx',

    'min' => array(
        'USD' => 20,
        'CNY' => 120
    ),
    'max' => array(
        'USD' => 10000,
        'CNY' => 60000
    ),

    'paymentNote' => 'payment_universal_note_astech',
);

$this->paymentsProcessingSystem['dengionline'] = array(
    'enabled' => true,
    'currency' => array('USD', 'RUB', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB'),
    'url' => 'https://www.onlinedengi.ru/wmpaycheck.php',

    'project' => 5189,
    'source' => 5189,

    'merchant_name' => 'WhoTrades',
    'securityKey' => 'A/*37F17xI80xUvf+$9;%G;#+.65&n1',

    'payment_systems' => array(
        // ad: removed since #WTT-869
        /* PaySystems::ALFA_BANK => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 76,
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.98
                ),

                'coef_conversion_fee' => 0.99,

                'additional_user_params' => array(
                    'AlfaClickUserID' => array('type' => 'text')
                )
            )
        ),*/

        // ad: since #WHO-4549
        PaySystems::LIQPAY => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'USD' => 360
                ),

                'coef_for_crediting' => array(
                    'USD' => 0.97
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        /*
        PaySystems::EASYPAY => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'BYR' => 16
                ),

                'additional_user_params' => array(
                    'easypay_card' => array('type' => 'text')
                )
            )
        ),
        */

        // ad: since #WHO-4549
        // ad: removed since #WTT-869
        /*PaySystems::DENGI_MAIL_RU => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 32
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.975
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),*/

        /*
        PaySystems::ELEXNET => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 64
                ),
            )
        ),
        */

        // ad: since #WHO-4549
        // ad: removed since #WTT-869
        /*PaySystems::EUROSET => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 62
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.975
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),*/

        PaySystems::PAYPAL => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'USD' => 616
                ),

                'coef_for_crediting' => array(
                    'USD' => 1
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        PaySystems::QIWI_WALLET => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 14
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.98
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        // ad: copy from QIWI_WALLET section / http://dengionline.com/dev/protocol/mode_type #WHO-4396
        PaySystems::QIWI_TERMINALS => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 14
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.98
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        // ad: since #WHO-4549
        // ad: removed since #WTT-869
        /*PaySystems::SVYAZNOY => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 230
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.975
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        PaySystems::CONTACT => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 75
                ),

                'coef_for_crediting' => array(
                    'RUB' => 1
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),*/

        PaySystems::WEBMONEY => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 2,
                    'USD' => 1,
                    'EUR' => 3
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                    'USD' => 0.98,
                    'EUR' => 0.98
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),

        PaySystems::YANDEX_MONEY => array(
            'enabled' => true,

            'params' => array(
                'currency_mode_type' => array(
                    'RUB' => 400,
                ),

                'coef_for_crediting' => array(
                    'RUB' => 0.975,
                ),

                'coef_conversion_fee' => 0.99,
            )
        ),
    ),

    'sms_verify_form' => false,
    'coef_for_crediting' => 1,

    'min' => array(
        'USD' => 0.005,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 450,
        'EUR' => 350,
        'RUB' => 15000
    ),

    'paymentNote' => 'payment_universal_note_dengionline',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// vdm+warl: callback url управляется через админку на https://secure.onpay.ru/merchants/edit: http://api.whotrades.com/api/payments-processing/onpay/
$this->paymentsProcessingSystem['onpay'] = array(
    'enabled' => true,

    'currency' => array('RUB', 'USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUR'),
    'url' => 'https://secure.onpay.ru/pay/www_whotrades_com',

    'return_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',

    'securityKey' => 'MolCPmE1HIg',

    'sms_verify_form' => false,

    'min' => array(
        'USD' => 100,
        'EUR' => 100,
        'RUB' => 3000
    ),
    'max' => array(
        'USD' => 450,
        'EUR' => 350,
        'RUB' => 15000
    ),

    // http://wiki.onpay.ru/doku.php?id=payment-links-specs
    // Принудительная конвертация платежей в валюту ценника.
    // пример, пользователь платит 3.5WMZ за ваш товар стоимостью 100RUR – вы получите 3.5WMZ
    'convert' => 'yes',

    'payment_system_ticker' => array(
        PaySystems::WEBMONEY_TEXT => array(
            'supportedCurrency' => array('USD', 'EUR', 'RUR'),

            'USD' => array('ticker' => 'WMZ', 'coef_for_crediting' => 0.996, 'commission' => 0.96),
            'EUR' => array('ticker' => 'WME', 'coef_for_crediting' => 0.996, 'commission' => 0.97),
            'RUR' => array('ticker' => 'WMR', 'coef_for_crediting' => 0.996, 'commission' => 1)
        ),
        PaySystems::YANDEX_MONEY_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'YDX', 'coef_for_crediting' => 0.975),
            'EUR' => array('ticker' => 'YDX', 'coef_for_crediting' => 0.975),
            'RUR' => array('ticker' => 'YDX', 'coef_for_crediting' => 0.975),
        ),
        PaySystems::RBK_MONEY_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'RBK', 'coef_for_crediting' => 0.985),
            'EUR' => array('ticker' => 'RBK', 'coef_for_crediting' => 0.985),
            'RUR' => array('ticker' => 'RBK', 'coef_for_crediting' => 0.985)
        ),
        PaySystems::DENGI_MAIL_RU_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'DMR', 'coef_for_crediting' => 0.975),
            'EUR' => array('ticker' => 'DMR', 'coef_for_crediting' => 0.975),
            'RUR' => array('ticker' => 'DMR', 'coef_for_crediting' => 0.975)
        ),
        PaySystems::MONEY_MAIL_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'MMR', 'coef_for_crediting' => 0.975),
            'EUR' => array('ticker' => 'MMR', 'coef_for_crediting' => 0.975),
            'RUR' => array('ticker' => 'MMR', 'coef_for_crediting' => 0.975),
        ),
        PaySystems::LIBERTY_RESERVE_TEXT => array(
            'supportedCurrency' => array('USD'),

            'EUR' => array('ticker' => 'LRU', 'coef_for_crediting' => 0.995, 'commission' => 0.97),
            'RUR' => array('ticker' => 'LRU', 'coef_for_crediting' => 0.995, 'commission' => 1),
            'USD' => array('ticker' => 'LRU', 'coef_for_crediting' => 0.995, 'commission' => 0.97)
        ),
        PaySystems::LIQPAY_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'RUR' => array('ticker' => 'LIQ', 'coef_for_crediting' => 0.995, 'commission' => 1),
            'USD' => array('ticker' => 'LIZ', 'coef_for_crediting' => 0.995, 'commission' => 0.95),
        ),
        PaySystems::ELEXNET_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'RUR' => array('ticker' => 'HBK', 'coef_for_crediting' => 0.985),
            'USD' => array('ticker' => 'HBK', 'coef_for_crediting' => 0.985),
            'EUR' => array('ticker' => 'HBK', 'coef_for_crediting' => 0.985),
        ),
        PaySystems::EUROSET_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'EUS', 'coef_for_crediting' => 0.985),
            'EUR' => array('ticker' => 'EUS', 'coef_for_crediting' => 0.985),
            'RUR' => array('ticker' => 'EUS', 'coef_for_crediting' => 0.985),
        ),
        PaySystems::CREDIT_CARD_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'OCE', 'coef_for_crediting' => 1),
            'EUR' => array('ticker' => 'OCE', 'coef_for_crediting' => 1),
            'RUR' => array('ticker' => 'OCE', 'coef_for_crediting' => 1)
        ),
        PaySystems::CREDIT_CARD2_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'OCE', 'coef_for_crediting' => 1),
            'EUR' => array('ticker' => 'OCE', 'coef_for_crediting' => 1),
            'RUR' => array('ticker' => 'OCE', 'coef_for_crediting' => 1)
        ),
        PaySystems::ALFA_BANK_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'ACL', 'coef_for_crediting' => 1),
            'EUR' => array('ticker' => 'ACL', 'coef_for_crediting' => 1),
            'RUR' => array('ticker' => 'ACL', 'coef_for_crediting' => 1)
        ),
        PaySystems::SVYAZNOY_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'SVZ', 'coef_for_crediting' => 0.985),
            'EUR' => array('ticker' => 'SVZ', 'coef_for_crediting' => 0.985),
            'RUR' => array('ticker' => 'SVZ', 'coef_for_crediting' => 0.985)
        ),
        PaySystems::QIWI_WALLET_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'QWA', 'coef_for_crediting' => 0.98),
            'EUR' => array('ticker' => 'QWA', 'coef_for_crediting' => 0.98),
            'RUR' => array('ticker' => 'QWA', 'coef_for_crediting' => 0.98)
        ),
        PaySystems::QIWI_TERMINALS_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'OSP', 'coef_for_crediting' => 0.98),
            'EUR' => array('ticker' => 'OSP', 'coef_for_crediting' => 0.98),
            'RUR' => array('ticker' => 'OSP', 'coef_for_crediting' => 0.98)
        ),
        PaySystems::SBR_ONLINE_TEXT => array(
            'supportedCurrency' => array('RUR'),

            'USD' => array('ticker' => 'SBR', 'coef_for_crediting' => 1),
            'EUR' => array('ticker' => 'SBR', 'coef_for_crediting' => 1),
            'RUR' => array('ticker' => 'SBR', 'coef_for_crediting' => 1),
        ),
    ),

    'coef_conversion_fee' => 0.99,

    'paymentNote' => 'payment_universal_note_onpay',
    'paymentNoteCommissionHardcoded' => true,
);

// ad: PayU PS #WHO-4577, callback url http://api.whotrades.com/api/payments-processing/payu/
$this->paymentsProcessingSystem['payu'] = array(
    'enabled' => true,

    'currency' => array('RUB', 'USD'),
    'currencyMap' => array('RUB' => 'RUB', 'USD' => 'USD'),
    'url' => 'https://secure.payu.ru/order/lu.php',
    'merchant' => 'servissl',

    'securityKey' => 'Bt8||3~8+k?i]Xx3]]H4',
    'order_pname' => 'Fund account on Whotrades.com',
    'order_pcode' => 1934592,

    'return_url' => 'https://whotrades.com/payments/result/success',
    'logo_url' => 'https://secure.payu.ru/images/epayment/powerby-PAYU_RU.gif',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/payu/',
        'idn_url' => 'https://secure.payu.ru/order/idn.php',
    ),

    'payment_systems' => array(
        PaySystems::CREDIT_CARD3 => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'CCVISAMC',

                'coef_for_crediting' => array(
                    'RUB' => 1,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::WEBMONEY => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'WEBMONEY',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::QIWI_WALLET => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'QIWI',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::QIWI_TERMINALS => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'QIWI',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::DENGI_MAIL_RU => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'MAILRU',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::YANDEX_MONEY => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'YANDEX',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
        PaySystems::ALFA_BANK => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'ALFACLICK',

                'coef_for_crediting' => array(
                    'RUB' => 0.98,
                ),
                'coef_conversion_fee' => 0.99,
            )
        ),
    ),

    'is_test' => false,
    'sms_verify_form' => false,
    'coef_for_crediting' => 1,

    'min' => array(
        'RUB' => 10,
        'USD' => 0.1,
    ),
    'max' => array(
        'RUB' => 300000,
        'USD' => 10000,
    ),

    'paymentNote' => 'payment_universal_note_payu',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: indonesian PS #WHO-3616, callback url http://api.whotrades.com/api/payments-processing/fasapay/
$this->paymentsProcessingSystem['fasapay'] = array(
    'enabled' => true,

    'currency' => array('USD', 'IDR'),
    'currencyMap' => array('USD' => 'USD', 'IDR' => 'IDR'),
    'url' => 'https://sci.fasapay.com/',
    'merchant' => 'FP35909',
    'fee_mode' => 'FiR', // FiR - Fee will be charged to the recipient (Merchant) / FiS - Fee will be charged to the sender (buyer) / FsC - Fee On Sender Choice

    'storeName' => 'Whotrades CY', // required to use advanced mode and securityKey
    'securityKey' => '3i;hd_fw328', // used only with valid storeName
    'advancedMode' => false, // allow to store return_url, fail_url and status_url in PS store settings instead of putting them into the form

    'return_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'https://www.fasapay.com/img/aff/120030',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/fasapay/',
    ),

    'sms_verify_form' => false,

    'coef_for_crediting' => 0.995,
    'coef_conversion_fee' => 0.99,

    // absolute fee minimum
    'min_fee' => array(
        'USD' => 0.01,
        'IDR' => 100,
    ),

    'min' => array(
        'USD' => 0.1,
        'IDR' => 1000,
    ),
    'max' => array(
        'USD' => 1000, // ad: in fact 1000000
        'IDR' => 10000000, // ad: in fact 10000000000
    ),

    'paymentNote' => 'payment_universal_note_fasapay',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: PSB #WTT-196, callback url http://api.whotrades.com/api/payments-processing/psb/
$this->paymentsProcessingSystem['psb'] = array(
    'enabled' => false,

    'currency' => array('RUB', 'USD'),
    'currencyMap' => array('RUB' => 'RUB', 'USD' => 'USD'),

    'url' => 'https://3ds.payment.ru/cgi-bin/cgi_link', // ad: для функционала REFUND порт открывался заявкой 80633
    'merchant' => '000621124033802',
    'terminal' => 24033802,
    'securityKey' => '36D897CB2DCE2AB6F6F6CD1BF4B8BFB0',

    'return_url' => 'https://whotrades.com/payments/result/generic?from_ps=psb',
    'fail_url' => 'https://whotrades.com/payments/result/generic?from_ps=psb',
    'logo_url' => 'http://online.payment.ru/i/logo.gif',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/psb/',
    ),

    'api_url_sync' => 'https://rs.psbank.ru:4443/cgi-bin/ecomm_check',

    'confirmation_timeout' => 10,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1, // RUB only
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 0.1,
        'RUB' => 10,
    ),
    'max' => array(
        'USD' => 400, // ad: !!!!!!!! никогда не должно быть больше 15000 рублей по курсу
        'RUB' => 15000, // ad: !!!!!! никогда не должно быть больше 15000 рублей
    ),

    'proxy_url' => 'https://www.finambank.ru/wallet/', // proxied to services/wt-wallet
    'proxy_cancel_url' => 'http://whotrades.com/payments/result/cancel',

    'paymentNote' => 'payment_universal_note_psb',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: RBK Money PS #WTT-185, callback url http://api.whotrades.com/api/payments-processing/rbkmoney/
$this->paymentsProcessingSystem['rbkmoney'] = array(
    'enabled' => true,

    'currency' => array('RUB', 'USD', 'EUR'),
    'currencyMap' => array('RUB' => 'RUR', 'USD' => 'USD', 'EUR' => 'EUR'),
    'url' => 'https://rbkmoney.ru/acceptpurchase.aspx',
    'eshopId' => array(
        'RUR' => 2024692, // RU146771598
        'USD' => 2024719, // RU599639853
        'EUR' => 2024718, // RU326131430
    ),
    'secretKey' => array(
        'RUR' => 'kfshk2873h',
        'USD' => '987dfewjgf3',
        'EUR' => 'fsoiur32wiu',
    ),
    'hashAlgorithm' => 'md5',
    'apiVersion' => 2, // 1 - 5 x 3 min callback calls, if failed, 2 - 480 x 3 min callback calls

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'https://rbkmoney.ru/img/logo.gif',

    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/rbkmoney/',
    ),

    'payment_systems' => array(
        PaySystems::RBK_MONEY => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'rbkmoney',

                'coef_for_crediting' => array(
                    'USD' => 1,
                    'EUR' => 1,
                    'RUR' => 0.974,
                ),
            )
        ),
        PaySystems::CREDIT_CARD_RBK => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'bankcard',

                'coef_for_crediting' => array(
                    'USD' => 1,
                    'EUR' => 1,
                    'RUR' => 1,
                ),
            )
        ),
        PaySystems::SVYAZNOY => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'svyaznoy',

                'coef_for_crediting' => array(
                    'USD' => 1,
                    'EUR' => 1,
                    'RUR' => 1,
                ),
            )
        ),
        PaySystems::EUROSET => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'euroset',

                'coef_for_crediting' => array(
                    'USD' => 1,
                    'EUR' => 1,
                    'RUR' => 1,
                ),
            )
        ),
        PaySystems::CONTACT => array(
            'enabled' => true,

            'params' => array(
                'pay_method' => 'contact',

                'coef_for_crediting' => array(
                    'USD' => 1,
                    'EUR' => 1,
                    'RUR' => 1,
                ),
            )
        ),
    ),

    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'RUB' => 1,
        'USD' => 0.1,
        'EUR' => 0.1,
    ),
    'max' => array(
        'RUB' => 300000, // proved
        'USD' => 9000, // rated
        'EUR' => 6000, // rated
    ),

    'paymentNote' => 'payment_universal_note_rbkmoney',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

/**
 * ad: Ukash PS #WTT-745, callback url http://api.whotrades.com/api/payments-processing/ukash/
 * support: Jayesh Integration@ukash.com
 */
$this->paymentsProcessingSystem['ukash'] = array(
    'enabled' => true,

    'currency' => array('RUB', 'USD', 'EUR'),
    'currencyMap' => array('RUB' => 'USD', 'USD' => 'USD', 'EUR' => 'EUR'),

    'url' => 'https://direct.ukash.com/hosted/entry.aspx',
    'rppUrl' => 'https://processing.ukash.com/RPPGateway/process.asmx',
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/ukash/',
    ),

    'requestToken' => '43PaG4V63K53P8K45Q34',
    'responseToken' => 'KCW63VaMVB6aH3UVWWUW',
    'brandId' => 'UKASH19955',
    'brandName' => 'www.whotrades.com',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'http://www.ukashbusiness.com/logopack_files/ukash-logo-medium.jpg',

    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'RUB' => 10,
        'USD' => 0.01,
        'EUR' => 0.01,
    ),
    'max' => array(
        'RUB' => 10000, // rated
        'USD' => 300, // proved
        'EUR' => 250, // proved
    ),

    'paymentNote' => 'payment_universal_note_ukash',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: Netbanx PS #WTT-825, callback url http://api.whotrades.com/api/payments-processing/netbanx/
$this->paymentsProcessingSystem['netbanx'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),

    'apiUrl' => 'https://api.netbanx.com/hosted/v1/orders',
    'apiKey' => array(
        'USD' => 'H9xKycASGZvOH1bcsHvR:PAA256dece1526ad126fccc',
        'EUR' => 'H9xKycASGZvOH1bcsHvR:PAA256dece1526ad126fccc',
    ),
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/netbanx/',
    ),

    'paymentMethod' => 'card',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'http://www.ukashbusiness.com/logopack_files/ukash-logo-medium.jpg',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 0.1,
        'EUR' => 0.1,
    ),
    'max' => array(
        'USD' => 3000,
        'EUR' => 3000,
    ),

    'paymentNote' => 'payment_universal_note_netbanx',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: Pay-Uni PS #WTI-38, callback url http://api.whotrades.com/api/payments-processing/payuni/
$this->paymentsProcessingSystem['payuni'] = array(
    'enabled' => true,

    'currency' => array('USD', 'CNY'),
    'currencyMap' => array('USD' => 'CNY', 'CNY' => 'CNY'),

    'url' => 'https://www.payuni-platform.com/pg/payment.php',
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/payuni/',
    ),

    'merchantId' => 10008684,
    'merchantPrefix' => 'puwho',
    'gatewayId' => 40, // prod
    'securityToken' => '0u8glkj34034rfl4fj320',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'http://www.payuni-platform.com/images/Etopbanner.jpg',

    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 0.1,
        'CNY' => 1
    ),
    'max' => array(
        'USD' => 10000, // in fact no limit, proved
        'CNY' => 60000, // in fact no limit, proved
    ),

    'paymentNote' => 'payment_universal_note_payuni',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: Inatec Payment AG PS #WTI-156, callback url http://api.whotrades.com/api/payments-processing/inatec/
$this->paymentsProcessingSystem['inatec'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'USD'),

    'api_url_sync' => 'https://pay4.powercash21.com/powercash21-3-2/backoffice/payment_authorize',
    'statusUrl' => 'https://pay4.powercash21.com/powercash21-3-2/backoffice/tx_diagnose',
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/inatec/',
    ),

    'merchantId' => '350701cc61f386b1b4ab0be475ed8b0c3138cd79',
    'securityKey' => 'v7kT7PPgwa',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'return_url' => 'https://whotrades.com/payments/result/generic',
    'logo_url' => 'http://www.inatec.com/img/inatecpayment_logo.jpg',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 10, // lk reduced min limit from 50 by zhilin email 07/08/2014,
        'EUR' => 10,
    ),
    'max' => array(
        'USD' => 5000,
        'EUR' => 5000,
    ),

    'paymentNote' => 'payment_universal_note_inatec',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: CashU PS #WTI-194, callback url http://api.whotrades.com/api/payments-processing/cashu/
$this->paymentsProcessingSystem['cashu'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),

    'url' => 'https://www.cashu.com/cgi-bin/pcashu.cgi',
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/cashu/',
        'response_url' => 'https://www.cashu.com/cgi-bin/notification/MerchantFeedBack.cgi',
    ),

    'merchantId' => 'Whotrades',
    'merchantPrefix' => 'wt',
    'securityKey' => '432098rue34',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'return_url' => 'https://whotrades.com/payments/result/generic',
    'logo_url' => 'https://images.cashu.com/images/cashULogo/en/122-25.jpg',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 50,
        'EUR' => 50,
    ),
    'max' => array(
        'USD' => 5000,
        'EUR' => 5000,
    ),

    'paymentNote' => 'payment_universal_note_cashu',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMin' => false,
);

// ad: Payza PS #WTI-138, callback url http://api.whotrades.com/api/payments-processing/payza/
$this->paymentsProcessingSystem['payza'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),

    'url' => 'https://secure.payza.com/checkout',
    'callback' => array(
        'url' => 'http://whotrades.com/api/payments-processing/payza/',
    ),

    'merchantId' => 'vperednev@office.whotrades.eu',
    'securityKey' => 'sFA9kJYHaYtCuFsf',

    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'return_url' => 'https://whotrades.com/payments/result/generic',
    'logo_url' => 'https://www.payza.com/images/payza-logo.png',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'feexed_for_crediting' => 0, // фиксированная комиссия
    'coef_for_crediting' => 0.98,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 10,
        'EUR' => 10,
    ),
    'max' => array(
        'USD' => 3000,
        'EUR' => 3000,
    ),

    'paymentNote' => 'payment_universal_note_payza',
    'paymentNoteCommissionHardcoded' => true,
    'withoutMax' => true,
);

$this->paymentsProcessingSystem['neteller'] = array(
    'enabled' => true,

    'currency' => array('USD', 'EUR'),
    'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR'),

    'clientId' => 'AAABR3y0mPq2VpXa',
    'clientSecret' => '0.uHBSupan6Rdr9ecSkODaq726-h55u7dtytMduziOSB8.EAAQUdxqkl7mAn5rs6IcW-SIcIKseoo',

    'apiUrlToken' => 'https://api.neteller.com/v1/oauth2/token?grant_type=client_credentials',
    'apiUrlPayment' => 'https://api.neteller.com/v1/transferIn',
    'apiUrlStatus' => 'https://api.neteller.com/v1/payments/',

    'return_url' => 'https://whotrades.com/payments/result/generic',
    'success_url' => 'https://whotrades.com/payments/result/success',
    'fail_url' => 'https://whotrades.com/payments/result/cancel',
    'logo_url' => 'http://upload.wikimedia.org/wikipedia/en/d/d7/Neteller-Logo-green_168w.png',

    'confirmation_timeout' => 30,
    'sms_verify_form' => false,

    'coef_for_crediting' => 1,
    'coef_conversion_fee' => 0.99,

    'min' => array(
        'USD' => 10,
        'EUR' => 10,
    ),
    'max' => array(
        'USD' => 5000,
        'EUR' => 3750,
    ),

    'paymentNote' => 'payment_universal_note_neteller',
    'paymentNoteCommissionHardcoded' => false,
    'withoutMax' => true,
);

// ad: config for local aggregators #WTT-392
$this->paymentsProcessingSystem['local_aggregator'] = array(
    \PaymentsProcessingSystem\LocalAggregators::WTWALLET => array(
        'use3card' => true, // ad: final switch #WTT-418
    ),
);


// ad: вывод средств #WTT-507
$this->paymentsProcessingSystem['cashout'] = array(

    'dengionline' => array(
        'enabled' => true,
        'currency' => array('USD', 'RUB', 'EUR'),
        'currencyMap' => array('USD' => 'USD', 'EUR' => 'EUR', 'RUB' => 'RUB'),
        'url' => 'https://gsg.dengionline.com/api',

        'project' => 6490,
        'securityKey' => '4igGqhBGC5mxPzeV3gg',
        'txnIdPrefix' => 'wt',

        'payment_systems' => array(
            PaySystems::QIWI_WALLET_TEXT => array(
                'enabled' => true,

                'params' => array(
                    'external_id' => array(2 => 'RUB'),
                )
            ),

            PaySystems::CREDIT_CARD_TEXT => array(
                'enabled' => true,

                'params' => array(
                    'external_id' => array(9 => 'RUB'),
                )
            ),

            PaySystems::WEBMONEY_TEXT => array(
                'enabled' => true,

                'params' => array(
                    'external_id' => array(
                        19 => 'RUB',
                        22 => 'EUR',
                        23 => 'USD',
                    ),
                )
            ),

            PaySystems::YANDEX_MONEY_TEXT => array(
                'enabled' => true,

                'params' => array(
                    'external_id' => array(33 => 'RUB'),
                )
            ),
        ),

        'max' => array(
            'RUB' => 0,
            'USD' => 0,
            'EUR' => 0,
        ),
    ),

);


//warl: конфиги для подключаемых мерчантов #WHO-827
$this->paymentsProcessingSystem['merchant'] = array(

    //lk: config for default recipient == WTLTD. since #WHO-3583
    Recipients::WHOTRADES_LTD => array(
        'global' => array(
            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::CREDIT_CARD_RBK_TEXT, // ad: #WTT-724
                PaySystems::WT_WALLET_TEXT,
                PaySystems::CREDIT_CARD_NETBANX_TEXT, // ad: #WTT-825
                PaySystems::CHINA_UNION_PAY_TEXT,
                PaySystems::CHINA_UNION_PAY_INATEC_TEXT, // ad: #WTI-156
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::BANK_TRANSFER_TEXT,
                PaySystems::SKRILL_TEXT,
                PaySystems::GIROPAY_TEXT,
                PaySystems::IDEAL_TEXT,
                PaySystems::DANKORT_TEXT,
                PaySystems::NORDEA_TEXT,
                PaySystems::POLI_TEXT,
                PaySystems::BOLETO_TEXT,
                PaySystems::LIBERTY_RESERVE_TEXT,
                PaySystems::CASHU_TEXT,
                PaySystems::QIWI_WALLET_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT, // ad: tests in hidden mode #WTT-185
                PaySystems::LIQPAY_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::P24_TEXT,
                PaySystems::ABAGOOS_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT,
                PaySystems::UKASH_TEXT,
                PaySystems::PSB_WALLET_TEXT, // ad: in hidden mode
                PaySystems::SBR_ONLINE_TEXT,
                PaySystems::PAYZA_TEXT, // ad: #WTI-138
                PaySystems::NETELLER_WALLET_TEXT
            ),

            'hidden_payment_systems' => array(),

            'payment_systems_source' => array(
                PaySystems::QIWI_WALLET => 'onpay', // ad: #WTI-280
                PaySystems::UKASH => 'ukash',
            ),

            // ad: WtWallet through PSB since #WTT-367
            'payment_method_rewrites' => array(
                PaySystems::WT_WALLET_TEXT => PaySystems::PSB_WALLET_TEXT,
            ),

            'conversions' => array(
                'ReorderMethods', // use \PaymentsProcessingSystem\Conversion\ReorderMethods, reorder payment methods #WTT-741, #WTI-213, #WTI-271
                'CurrencyLang', // use \PaymentsProcessingSystem\Conversion\CurrencyLang, rewrite aggregator for credit cards (currency=RUB || lcid=th) #WHO-4527 (#WHO-1739 & #WHO-4108)
                'MctRrmEcnAccounts', // use \PaymentsProcessingSystem\Conversion\MctRrmEcnAccounts, use special commissions for Mct, Rrm, Ecn accounts #WHO-4608
                'AccountsTypes', // use \PaymentsProcessingSystem\Conversion\AccountsTypes, PS min-max limits for accounts types #WHO-4646
                'RecipientWtltdMethods', // use \PaymentsProcessingSystem\Conversion\RecipientWtltdMethods, hide some payment methods for WTLTD #WTT-741
                'AccountTypeRrmMethods', // use \PaymentsProcessingSystem\Conversion\AccountTypeRrmMethods, hide some payment methods for Rrm accounts #WHO-4608
                'AccountTypeFmeMethods', // use \PaymentsProcessingSystem\Conversion\AccountTypeFmeMethods, hide all payment methods for Fme accounts #WTT-338
                'AccountTypeTransaqUsaMethods', // use \PaymentsProcessingSystem\Conversion\AccountTypeTransaqUsaMethods, hide all payment methods for TransaqUSA accounts #WTI-186
                'AccountTypeRoxXetraMethods', // use \PaymentsProcessingSystem\Conversion\AccountTypeRoxXetraMethods, hide some payment methods for Rox & Xetra accounts
                'AccountTypeUnknownMethods', // use \PaymentsProcessingSystem\Conversion\AccountTypeUnknownMethods, hide some payment methods for unknown type accounts #WTT-543
                'AccountTypeLangWtWallet', // use \PaymentsProcessingSystem\Conversion\AccountTypeLangWtWallet, hide wt-wallet for russian and some type accounts #WTT-392
            ),
        ),
    ),

    Recipients::EXTERNAL_FL => array(
        'global' => array(
            // ad: some sub-sections copied from Recipients::WHOTRADES_LTD

            'success_url' => 'https://cabinet.whotrades.com/FundsDeposit/PaymentSuccess/',
            'return_url' => 'https://cabinet.whotrades.com/FundsDeposit/PaymentSuccess/', // only for payonline! refactor this!
            'fail_url' => 'https://cabinet.whotrades.com/FundsDeposit/PaymentFail/',
            'generic_url' => 'https://cabinet.whotrades.com/FundsDeposit/PaymentComplete/',
            'merchant_url' => 'https://cabinet.whotrades.com/',
            'merchant_name' => 'FINAM.eu', // max 9 chars

            'notify_backoffice' => true,
        ),

        PaySystems::ONPAY => array(
            'min' => array(
                'USD' => 0.01,
                'EUR' => 0.01,
                'RUB' => 1
            ),
        ),

        PaySystems::MASTERBANK => array(
            'country' => null, // by param
        ),

        // ad: aggregators sub-sections copied from Recipients::WHOTRADES_LTD
    ),


    Recipients::WEBINARS => array(
        'global' => array(
            // ad: through SYC since #WTT-586
            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_WALLET_TEXT
            ),
            'success_url' => 'http://www.finam.ru/webinar/list0000E00001/default.asp',
            'fail_url' => 'http://www.finam.ru/webinar/list0000E00002/default.asp',
            'generic_url' => 'http://www.finam.ru/webinar/list0000E00003/default.asp',
            'merchant_url' => 'http://www.finam.ru/webinar/list0000E00003/default.asp',
            'merchant_name' => 'Webinar', // max 9 chars
            'min' => array(
                'USD' => 0.01,
                'EUR' => 0.01,
                'RUB' => 10
            ),
            'payment_systems_source' => array(
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::QIWI_WALLET => 'dengionline',
                PaySystems::YANDEX_MONEY => 'dengionline',
            ),
        ),

        /*PaySystems::MASTERBANK => array(
            'url' => 'https://web3ds.masterbank.ru/cgi-bin/cgi_link',
            'country' => 'RU',
            'terminal' => '71844508',
        ),*/
        PaySystems::PAYONLINE     => array(
            'enabled' => true,
            // ad: New terminal for pay learning via PAYONLINE #WTI-332
            'merchant' => 63449,
            'securityKey' => '5bc2867a-c275-416e-bfeb-f206fb1e6da0',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),
        PaySystems::DENGIONLINE   => array(
            'enabled' => true,
        ),
    ),

    Recipients::EXTERNAL_FL_SYC_RRM_MCT => array(
        'global' => array(
            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT,
                PaySystems::LIQPAY_TEXT,
                PaySystems::MONEY_MAIL_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT,
                PaySystems::PAYPAL_TEXT
            ),
            'success_url' => 'https://cabinet.finam.eu/FundsDeposit/PaymentSuccess/',
            'return_url' => 'https://cabinet.finam.eu/FundsDeposit/PaymentSuccess/', // only for payonline! refactor this!
            'fail_url' => 'http://finameumain.msa-webtest1.finam.ru/FundsDeposit/PaymentFail/',
            'generic_url' => 'https://cabinet.finam.eu/FundsDeposit/PaymentGeneric/',
            'merchant_url' => 'https://cabinet.finam.eu/',
            'merchant_name' => 'FINAM.eu', // max 9 chars

            'notify_backoffice' => true,

            'payment_systems_source' => array(
                PaySystems::ALFA_BANK => 'onpay', // vdm: переключил на opnay т.к. для dengionline не подключено по словам Павла Львова
                PaySystems::QIWI_TERMINALS => 'dengionline',
                PaySystems::PAYPAL => 'dengionline',
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::CREDIT_CARD => 'payonline',
            ),

            'min' => array(
                'USD' => 0.01
            ),
        ),

        PaySystems::ONPAY => array(
            'url' => 'https://secure.onpay.ru/pay/forex_light',
            'securityKey' => 'Ajtjru39hgDUTJN4',
        ),
        PaySystems::PAYONLINE => array(
            'enabled' => true,
            'merchant' => 56269,
            'securityKey' => 'c624eec7-207d-4c0e-a82b-d1f7dd63d5d6',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),

        PaySystems::MASTERBANK => array('enabled' => false),
    ),

    Recipients::EXOTIC_OPTIONS => array(
        'global' => array(
            'merchant_name' => 'Exotic op', // max 9 chars
            'return_url' => 'https://exotic-options.whotrades.com/payments/result/success',
            'fail_url' => 'https://exotic-options.whotrades.com/payments/result/cancel',

            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::WT_WALLET_TEXT,
                PaySystems::PSB_WALLET_TEXT,
                /*PaySystems::CREDIT_CARD3_TEXT,*/
                PaySystems::CHINA_UNION_PAY_TEXT,
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::FASAPAY_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT,
                PaySystems::LIQPAY_TEXT,
                PaySystems::MONEY_MAIL_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT,
                PaySystems::QIWI_WALLET_TEXT,
                PaySystems::PAYPAL_TEXT,
                PaySystems::SBR_ONLINE_TEXT
            ),

            'hidden_payment_systems' => array(
            ),

            //warl: возможно, потом нужно будет делать более сложную логику, к примеру, как на WT (по currency), тогда уже нужно будет делать отдельные контроллеры
            'payment_systems_source' => array(
                PaySystems::QIWI_WALLET => 'onpay',
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::CREDIT_CARD => 'payonline',
                //PaySystems::DENGI_MAIL_RU => 'payu',
                PaySystems::PAYPAL => 'dengionline',
                //PaySystems::ALFA_BANK => 'payu',
                PaySystems::CHINA_UNION_PAY => 'payuni', // ad: #WTI-112
            ),

            // ad: WtWallet through PSB since #WTT-367
            'payment_method_rewrites' => array(
                PaySystems::WT_WALLET_TEXT => PaySystems::PSB_WALLET_TEXT,
            ),

            'currency' => array('USD', 'IDR', 'CNY'), // ad: works for Widget only #WTT-968, #WTI-112

            'min' => array(
                'RUB' => 800,
                'USD' => 20,
                'EUR' => 20,
                'IDR' => 250000,
                'CNY' => 125,
            ),

            'conversions' => array(
                'EoLangMethods', // use \PaymentsProcessingSystem\Conversion\EoLangMethods, hide some payment methods for foreigners
                'AccountTypeLangWtWallet', // use \PaymentsProcessingSystem\Conversion\AccountTypeLangWtWallet, hide wt-wallet for russian and some type accounts #WTT-392
            ),
        ),
        PaySystems::ONPAY => array(
            'url' => 'https://secure.onpay.ru/pay/exotic_options',
            'securityKey' => 'Ajtjru39hgDUTJN4',
            'currency' => array('USD'),

            //warl: since #WHO-3425
            'convert' => 'no',
            'max' => array( // ad: #WTT-706
                'USD' => 400,
            ),

            // ad: #WTI-104
            'payment_system_ticker' => array(
                PaySystems::ALFA_BANK_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::WEBMONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98),
                    'EUR' => array('coef_for_crediting' => 0.98),
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::YANDEX_MONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.975), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.975),
                ),
                PaySystems::QIWI_WALLET_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::QIWI_TERMINALS_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
            ),
        ),
        PaySystems::PAYONLINE => array(
            'enabled' => true,
            'merchant' => 46683,
            'securityKey' => '5946bd89-f9b2-4bcb-853e-025d0f3a8986',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),
        PaySystems::DENGIONLINE   => array(
            'enabled' => true,
            'project' => 5924,
            'source' => 5924,
            'max' => array( // ad: #WTT-706
                'USD' => 400,
            ),
        ),
        PaySystems::PAYU          => array(
            'enabled' => true,
            'max' => array(
                'USD' => 3000,
            ),
        ),
        // ad: for WtWallet
        PaySystems::PSB           => array(
            'return_url' => 'https://www.finambank.ru/wallet/payments/result?from_ps=psb',
            'proxy_cancel_url' => 'https://exotic-options.whotrades.com/payments/result/cancel',
            'max' => array(
                'USD' => 400, // ad: !!!!!!!! никогда не должно быть больше 15000 рублей по курсу
            ),
        ),
        PaySystems::FASAPAY       => array(
            'enabled' => true,
            'max' => array( // ad: #WTT-903
                'USD' => 400,
                'IDR' => 5000000,
            ),
        ),
        // ad: #WTI-112
        PaySystems::PAYUNI        => array(
            'enabled' => true,
            'coef_for_crediting' => 0.975,
        ),

        //warl: отключаем все платежки кроме onpay и payonline
        //TODO: сделать возможность включать только конкретный список платежных систем, а остальные отключать
        PaySystems::MASTERBANK    => array('enabled' => false),
        PaySystems::PAYPAL        => array('enabled' => false),
        PaySystems::MONEYBOOKERS  => array('enabled' => false),
        PaySystems::QIWI          => array('enabled' => false),
        PaySystems::ALGOCHARGE    => array('enabled' => false),
        PaySystems::ASTECH        => array('enabled' => false),
    ),

    // ad: #WTI-234
    Recipients::NON_EXCHANGE_OPTIONS => array(
    ),

    //warl: like exotic options recipient config, change if need
    Recipients::WHOTRADES_SYC => array(
        'global' => array(
            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::WT_WALLET_TEXT,
                /*PaySystems::CREDIT_CARD3_TEXT, */
                PaySystems::CHINA_UNION_PAY_TEXT,
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT,
                PaySystems::LIQPAY_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT,
                PaySystems::CASHU_TEXT, // ad: #WTI-194
                PaySystems::QIWI_WALLET_TEXT,
                PaySystems::PAYPAL_TEXT,
                PaySystems::PSB_WALLET_TEXT,
                PaySystems::FASAPAY_TEXT,
                PaySystems::SBR_ONLINE_TEXT
            ),

            'hidden_payment_systems' => array(
            ),

            'payment_systems_source' => array(
                PaySystems::QIWI_WALLET => 'onpay',
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::PAYPAL => 'dengionline',
                PaySystems::CREDIT_CARD => 'payonline',
                PaySystems::CHINA_UNION_PAY => 'payuni', // ad: #WTI-112
                PaySystems::CASHU => 'cashu', // ad: #WTI-194
            ),

            // ad: WtWallet through PSB since #WTT-367
            'payment_method_rewrites' => array(
                PaySystems::WT_WALLET_TEXT => PaySystems::PSB_WALLET_TEXT,
            ),

            'currency' => array('USD', 'CNY'), // ad: works for Widget only #WTT-968 #WTI-180

            'min' => array( // ad: #WTT-903
                'RUB' => 150,
                'USD' => 5,
                'EUR' => 5,
                'IDR' => 120000,
                'CNY' => 35,
            ),

            'conversions' => array(
                'AccountsTypes', // use \PaymentsProcessingSystem\Conversion\AccountsTypes, PS min-max limits for accounts types #WHO-4646
                'AccountTypeLangWtWallet', // use \PaymentsProcessingSystem\Conversion\AccountTypeLangWtWallet, hide wt-wallet for russian and some type accounts #WTT-392
                'RecipientWtshCoefForCrediting', // use \PaymentsProcessingSystem\Conversion\RecipientWtshCoefForCrediting, keep coef. for Onpay equal to DengiOnlines' #WTT-869
            ),
        ),
        PaySystems::ONPAY         => array(
            'url' => 'https://secure.onpay.ru/pay/forex_light',
            'securityKey' => 'Ajtjru39hgDUTJN4',

            // ad: #WTI-104
            'payment_system_ticker' => array(
                PaySystems::ALFA_BANK_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::WEBMONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98),
                    'EUR' => array('coef_for_crediting' => 0.98),
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::YANDEX_MONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.975), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.975),
                ),
                PaySystems::LIQPAY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.97), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.97),
                ),
                PaySystems::QIWI_WALLET_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::QIWI_TERMINALS_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
            ),
        ),
        PaySystems::PAYONLINE     => array(
            'enabled' => true,
            'merchant' => 56269,
            'securityKey' => 'c624eec7-207d-4c0e-a82b-d1f7dd63d5d6',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),
        PaySystems::PAYU          => array(
            'enabled' => true,
            'max' => array(
                'USD' => 3000,
            ),
        ),
        PaySystems::FASAPAY       => array( // ad: #WTT-903
            'enabled' => true,
            'max' => array(
                'USD' => 1000,
                'IDR' => 12000000,
            ),
        ),

        // ad: #WTT-837
        PaySystems::ASTECH        => array(
            'enabled' => true,

            'merchant_id' => 'WHOT000416',

            'store_id' => array(
                'china-union-pay' => 'WhotradesSyc',
            ),

            'brand_id' => 'T1479T_WHOTASrm1',

            'api_password' => 'jkdk4352JK',

            'securityKey' => 'lr398f:34r7_#jkh',
        ),

        //warl: отключаем все платежки кроме onpay
        //TODO: сделать возможность включать только конкретный список платежных систем, а остальные отключать
        PaySystems::MASTERBANK    => array('enabled' => false),
        PaySystems::PAYPAL        => array('enabled' => false),
        PaySystems::MONEYBOOKERS  => array('enabled' => false),
        PaySystems::QIWI          => array('enabled' => false),
        PaySystems::ALGOCHARGE    => array('enabled' => false),
    ),

    Recipients::EXTERNAL_FL_SYC => array(
        'global' => array(
            // ad: some sub-sections copied from Recipients::WHOTRADES_SYC

            'success_url' => 'https://wtshcab.whotrades.com/FundsDeposit/PaymentSuccess/',
            'return_url' => 'https://wtshcab.whotrades.com/FundsDeposit/PaymentSuccess/', // only for payonline! refactor this!
            'fail_url' => 'https://wtshcab.whotrades.com/FundsDeposit/PaymentFail/',
            'generic_url' => 'https://wtshcab.whotrades.com/FundsDeposit/PaymentComplete/',
            'merchant_url' => 'https://wtshcab.whotrades.com/',
            'merchant_name' => 'FINAM.eu', // max 9 chars

            'notify_backoffice' => true,
        ),

        // ad: aggregators sub-sections copied from Recipients::WHOTRADES_SYC
    ),

    //lk: Learning, since #WHO-3583
    Recipients::LEARNING => array(
        'global' => array(
            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                /*PaySystems::CREDIT_CARD3_TEXT , */
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT,
                PaySystems::LIQPAY_TEXT,
                PaySystems::MONEY_MAIL_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT
            ),

            'payment_systems_source' => array(
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::QIWI_TERMINALS => 'dengionline',
                PaySystems::YANDEX_MONEY => 'dengionline',
                PaySystems::CREDIT_CARD => 'payonline',
            ),

            'conversions' => array(
                'LearningMinLimit', // use \PaymentsProcessingSystem\Conversion\LearningMinLimit, Fix min limit for learning #WTT-151
            ),
        ),
        //TODO lk: onpay real-prod config for learning
        PaySystems::ONPAY => array(
            'url' => 'https://secure.onpay.ru/pay/whotrades_learning',
            'securityKey' => 'R82v12urNZ',
            'return_url' => 'https://whotrades.com/payments/result/success?recipient=' . Recipients::LEARNING,
            'fail_url' => 'https://whotrades.com/payments/result/cancel?recipient=' . Recipients::LEARNING,
            'currency' => array('USD', 'EUR', 'RUB'),
            //lk: fake limit by Gorin 06/06/2013
            'min' => array(
                'USD' => 1,
                'RUB' => 30,
                'EUR' => 1,
            ),
            'max' => array(
                'USD' => 1000,
                'RUB' => 30000,
                'EUR' => 1000,
            ),
        ),
        PaySystems::PAYONLINE => array(
            'enabled' => true,
            // ag: New terminal for pay learning via PAYONLINE #WTI-332
            'merchant' => 63449,
            'securityKey' => '5bc2867a-c275-416e-bfeb-f206fb1e6da0',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),
        PaySystems::DENGIONLINE   => array(
            'enabled' => true,
        ),
        PaySystems::PAYU          => array(
            'enabled' => true
        ),

        //warl: отключаем все платежки кроме onpay
        //TODO: сделать возможность включать только конкретный список платежных систем, а остальные отключать
        PaySystems::MASTERBANK    => array('enabled' => false),
        PaySystems::PAYPAL        => array('enabled' => false),
        PaySystems::MONEYBOOKERS  => array('enabled' => false),
        PaySystems::QIWI          => array('enabled' => false),
        PaySystems::ALGOCHARGE    => array('enabled' => false),
        PaySystems::ASTECH        => array('enabled' => false),
        PaySystems::FASAPAY       => array('enabled' => false),
    ),

    //lk: since #WHO-3849
    Recipients::TRADE_REPEATER => array(
        'global' => array(
            // lk: TODO: ensure TradeRepeater merchant name
            'merchant_name' => 'trade_rep', // max 9 chars
            //'return_url' => 'https://exotic-options.whotrades.com/payments/result/success',
            //'fail_url' => 'https://exotic-options.whotrades.com/payments/result/cancel',

            'available_payment_systems' => array(
                PaySystems::CREDIT_CARD_TEXT,
                PaySystems::WT_WALLET_TEXT,
                PaySystems::PSB_WALLET_TEXT,
                /*PaySystems::CREDIT_CARD3_TEXT, */
                PaySystems::CHINA_UNION_PAY_TEXT,
                PaySystems::ALFA_BANK_TEXT,
                PaySystems::LIBERTY_RESERVE_TEXT,
                PaySystems::WEBMONEY_TEXT,
                PaySystems::YANDEX_MONEY_TEXT,
                PaySystems::RBK_MONEY_TEXT,
                PaySystems::LIQPAY_TEXT,
                PaySystems::MONEY_MAIL_TEXT,
                PaySystems::DENGI_MAIL_RU_TEXT,
                PaySystems::QIWI_TERMINALS_TEXT,
                PaySystems::ELEXNET_TEXT,
                PaySystems::EUROSET_TEXT,
                PaySystems::SVYAZNOY_TEXT,
                PaySystems::QIWI_WALLET_TEXT,
                PaySystems::PAYPAL_TEXT,
                PaySystems::FASAPAY_TEXT,
                PaySystems::SBR_ONLINE_TEXT
            ),

            'payment_systems_source' => array(
                PaySystems::QIWI_WALLET => 'dengionline',
                PaySystems::WEBMONEY => 'dengionline',
                PaySystems::CREDIT_CARD => 'payonline',
                PaySystems::PAYPAL => 'dengionline',
                //PaySystems::ALFA_BANK => 'payu',
                PaySystems::CHINA_UNION_PAY => 'payuni', // ad: #WTI-112
            ),

            // ad: WtWallet through PSB since #WTT-367
            'payment_method_rewrites' => array(
                PaySystems::WT_WALLET_TEXT => PaySystems::PSB_WALLET_TEXT,
            ),

            'currency' => array('USD', 'IDR'), // ad: works for Widget only #WTT-968

            'min' => array(
                // lk: min TR payment == 10$ by dmsh request 22/11/2013
                // bn: min TR payment == 50$ @since #WTT-347
                'RUB' => 2000,
                'USD' => 50,
                'EUR' => 50,
                'IDR' => 600000,
                'CNY' => 320,
            ),

            'conversions' => array(
                'AccountTypeLangWtWallet', // use \PaymentsProcessingSystem\Conversion\AccountTypeLangWtWallet, hide wt-wallet for russian and some type accounts #WTT-392
            ),
        ),
        // lk: TODO: ensure TradeRepeater ONPAY params like exotic-options
        PaySystems::ONPAY => array(
            'url' => 'https://secure.onpay.ru/pay/trade_repeater',
            'securityKey' => 'cTOxPNsWh38D13MD',
            'currency' => array('USD'),

            'max' => array( // ad: #WTT-903
                'USD' => 400,
            ),

            //warl: since #WHO-3425
            'convert' => 'no',

            // ad: #WTI-104
            'payment_system_ticker' => array(
                PaySystems::ALFA_BANK_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::WEBMONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98),
                    'EUR' => array('coef_for_crediting' => 0.98),
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::YANDEX_MONEY_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.975), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.975),
                ),
                PaySystems::QIWI_WALLET_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
                PaySystems::QIWI_TERMINALS_TEXT => array(
                    'USD' => array('coef_for_crediting' => 0.98), // ad: for comp. with Widget
                    'RUR' => array('coef_for_crediting' => 0.98),
                ),
            ),
        ),
        PaySystems::PAYONLINE => array(
            'enabled' => true,
            'merchant' => 56269,
            'securityKey' => 'c624eec7-207d-4c0e-a82b-d1f7dd63d5d6',
            'url' => 'https://secure.payonlinesystem.com/en/payment/',
            'lcid2UrlMap' => array(
                'ru' => 'https://secure.payonlinesystem.com/ru/payment/',
            ),
        ),
        PaySystems::DENGIONLINE   => array(
            'enabled' => true,
            'max' => array( // ad: #WTT-903
                'USD' => 400,
            ),
        ),
        PaySystems::PAYU          => array(
            'enabled' => true,
            'max' => array(
                'USD' => 3000,
            ),
        ),
        // ad: for WtWallet
        PaySystems::PSB           => array(
            'return_url' => 'https://www.finambank.ru/wallet/payments/result?from_ps=psb',
            'max' => array(
                'USD' => 400, // ad: !!!!!!!! никогда не должно быть больше 15000 рублей по курсу
            ),
        ),
        PaySystems::FASAPAY       => array(
            'enabled' => true,
            'max' => array( // ad: #WTT-903
                'USD' => 1000,
            ),
        ),
        // ad: #WTI-112
        PaySystems::PAYUNI        => array(
            'enabled' => true,
            'coef_for_crediting' => 0.975,
        ),

        //warl: отключаем все платежки кроме onpay
        //TODO: сделать возможность включать только конкретный список платежных систем, а остальные отключать
        PaySystems::MASTERBANK    => array('enabled' => false),
        PaySystems::PAYPAL        => array('enabled' => false),
        PaySystems::MONEYBOOKERS  => array('enabled' => false),
        PaySystems::QIWI          => array('enabled' => false),
        PaySystems::ALGOCHARGE    => array('enabled' => false),
        PaySystems::ASTECH        => array('enabled' => false),
    )
);

// warl: Нужно убрать циклы в конфигах!!!
// ad: зачем? 99% настроек для внешнего кабинета повторяют настройки соот. локальных мерчантов
foreach (array(Recipients::WHOTRADES_LTD => Recipients::EXTERNAL_FL, Recipients::WHOTRADES_SYC => Recipients::EXTERNAL_FL_SYC) as $merchantFrom => $merchantTo) {
    foreach (array('available_payment_systems', 'hidden_payment_systems', 'payment_systems_source', 'payment_method_rewrites', 'currency', 'min', 'conversions') as $sectionName) {
        if (isset($this->paymentsProcessingSystem['merchant'][$merchantFrom]['global'][$sectionName])) {
            $this->paymentsProcessingSystem['merchant'][$merchantTo]['global'][$sectionName] = $this->paymentsProcessingSystem['merchant'][$merchantFrom]['global'][$sectionName];
        }
    }
    foreach (PaySystems::$directoryTextNames as $psKey => $psName) {
        if (isset($this->paymentsProcessingSystem['merchant'][$merchantFrom][$psKey])) {
            $this->paymentsProcessingSystem['merchant'][$merchantTo][$psKey] = $this->paymentsProcessingSystem['merchant'][$merchantFrom][$psKey];
        }
    }
}

// ad: пока новый сервис копирует EO #WTI-234
$this->paymentsProcessingSystem['merchant'][Recipients::NON_EXCHANGE_OPTIONS] = $this->paymentsProcessingSystem['merchant'][Recipients::EXOTIC_OPTIONS];

// ad: конфиги для ссылок и сообщений на странице успешного пополнения счёта #WHO-3466
$this->paymentsProcessingSystem['recipientPaymentSuccessCookieName'] = 'paymentRecipient';
$this->paymentsProcessingSystem['recipientPaymentSuccess'] = array(
    Recipients::WHOTRADES_LTD => array(
        'dicLink' => 'payment_success_button_text_cabinet',
        'link'    => 'groups_item_cabinet'
    ),
    Recipients::WHOTRADES_SYC => array(
        'dicLink' => 'payment_success_button_text_cabinet',
        'link'    => 'groups_item_cabinet'
    ),
    Recipients::WEBINARS => array(
    ),
    Recipients::EXOTIC_OPTIONS => array(
        'dicLink' => 'payment_success_button_text_exotic_options',
        'link'    => 'exotic_options__profile'
    ),
    Recipients::NON_EXCHANGE_OPTIONS => array(
        'dicLink' => 'payment_success_button_text_exotic_options',
        'link'    => 'exotic_options__profile'
    ),
    Recipients::LEARNING => array(
        'dicLink' => 'payment_success_button_text_learning',
        // ad: ссылка на оплаченный курс #WHO-3961
        'link'    => 'groups_item_learning',
        'params_required' => array('second_url_part'),
        'params_incomplete_link' => 'groups_item_learning_simple'
    ),
    Recipients::TRADE_REPEATER => array(
        'dicLink' => 'payment_success_button_text_trade_repeater',
        'link'    => 'groups_item_trade_repeater_strategies',
        'dicText' => 'trade_repeater_payment-success__content'
    ),
);

$this->paymentsProcessingSystem['creditCardPaymentSystem'] = PaySystems::PAYONLINE;

$this->paymentsProcessingSystem['creditCardPaymentSystemName'] =
        strtolower(PaySystems::getTextNameByKey($this->paymentsProcessingSystem['creditCardPaymentSystem']));

// kz: PS depence currency & lang #WHO-1739
$this->paymentsProcessingSystem['cardsPaymentSystems'] = array (
    //warl: для тайцев всегда мастербанк из-за проблемлем с 3ds. since #WHO-4108
    // ad: masterbank temporary unavailable
    'USD'   => array(
        'en'    => PaySystems::PAYONLINE,
        'th'    => PaySystems::PAYONLINE, // MASTERBANK
    ),
    'EUR'   => array(
        'en'    => PaySystems::PAYONLINE,
        'th'    => PaySystems::PAYONLINE, // MASTERBANK
    ),
    'RUB'   => array(
        'en'    => PaySystems::PAYONLINE, // MASTERBANK
        'th'    => PaySystems::PAYONLINE, // MASTERBANK
    ),
);

// ad: PS commissions for Mct, Rrm, Ecn accounts #WHO-4608
$this->paymentsProcessingSystem['accountsMctRrmEcnCommissions'] = array (
    PaySystems::CREDIT_CARD . '/' . PaySystems::PAYONLINE => array(
        'coef_for_crediting' => 0.97 ), // ad: #WTT-852
    PaySystems::CREDIT_CARD . '/' . PaySystems::MASTERBANK => array(
        'coef_for_crediting' => 0.97 ),
    PaySystems::CREDIT_CARD2 => array( // ad: #WHO-4844
        'coef_for_crediting' => 0.971 ),
    PaySystems::CREDIT_CARD_RBK => array( // ad: #WTT-724 #WTT-774
        'coef_for_crediting' => 0.97 ),
    PaySystems::PSB_WALLET => array( // ad: rewritten from wt-wallet #WTT-764
        'coef_for_crediting' => 0.97 ),
    PaySystems::CREDIT_CARD_NETBANX => array( // ad: #WTT-992
        'coef_for_crediting' => 0.97 ),
    PaySystems::ALFA_BANK => array(
        'coef_for_crediting' => 0.96 ),
    PaySystems::WEBMONEY => array(
        'coef_for_crediting' => 0.982,
        'commission' => array(
            'RUB' => 0.96,
            'USD' => 0.96,
            'EUR' => 0.96
        ),
        'multiply_coef_for_crediting_commission' => true),
    PaySystems::YANDEX_MONEY => array(
        'coef_for_crediting' => 0.93 ),
    PaySystems::DENGI_MAIL_RU => array(
        'coef_for_crediting' => 0.94 ),
    PaySystems::LIQPAY => array(
        'coef_for_crediting' => 0.98,
        'commission' => array(
            'RUB' => 0.95,
            'USD' => 0.95,
            'EUR' => 0.95
        ),
        'multiply_coef_for_crediting_commission' => true),
    PaySystems::ELEXNET => array(
        'coef_for_crediting' => 0.955 ),
    PaySystems::EUROSET => array(
        'coef_for_crediting' => 0.96 ),
    PaySystems::SVYAZNOY => array(
        'coef_for_crediting' => 0.96 ),
    PaySystems::QIWI_TERMINALS => array(
        'coef_for_crediting' => 0.95 ),
    PaySystems::QIWI_WALLET => array(
        'coef_for_crediting' => 0.96,
        'commission' => array(
            'RUB' => 1,
            'USD' => 1,
            'EUR' => 1
        )),
    // ad: since #WTT-447
    PaySystems::CHINA_UNION_PAY => array(
        'coef_for_crediting' => 0.94 ),
    // ad: #WTI-156
    PaySystems::CHINA_UNION_PAY_INATEC => array(
        'coef_for_crediting' => 0.94 ),
    PaySystems::MONEYBOOKERS => array(
        'coef_for_crediting' => 0.971 ),
    PaySystems::CASHU => array(
        'coef_for_crediting' => 0.95 ),
    PaySystems::PAYZA => array( // ad: #WTI-138
        'feexed_for_crediting' => 0.59, // фиксированная комиссия
        'coef_for_crediting' => 0.961 ),
    PaySystems::NETELLER => array(
        'coef_for_crediting' => 0.971 ),
);

// ad: PS min-max limits for accounts types #WHO-4646
// attention! avoid recursion when using fictive groups in config
$this->paymentsProcessingSystem['accountsTypesLimits'] = array (
    AccountsTypes::MT4 => array(
        PaySystems::CREDIT_CARD => array(
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 100000,
                'USD' => 3000,
                'EUR' => 2000,
            ),
        ),
        PaySystems::CREDIT_CARD2 => array( // ad: #WHO-4844
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 30000,
                'USD' => 900,
                'EUR' => 600,
            ),
        ),
        /*PaySystems::CREDIT_CARD3 => array( // ad: #WTT-185
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 30000,
                'USD' => 900,
                'EUR' => 600,
            ),
        ),*/
        PaySystems::PSB_WALLET => array( // ad: rewritten from wt-wallet #WTT-992
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
        ),
        PaySystems::CREDIT_CARD_RBK => array(
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'USD' => 2500,
                'EUR' => 2000,
                'RUB' => 100000
            ),
        ),
        PaySystems::CREDIT_CARD_NETBANX => array(
            'min' => array(
                'USD' => 10,
                'EUR' => 10,
            ),
        ),
        PaySystems::PAYZA => array(
            'min' => array(
                'USD' => 10,
                'EUR' => 10,
            ),
        ),
        PaySystems::ONPAY => array( // ad: #WTT-706
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 15000,
                'USD' => 400,
                'EUR' => 300,
            ),
        ),
        PaySystems::QIWI_WALLET => PaySystems::ONPAY,
        PaySystems::MONEY_MAIL => PaySystems::ONPAY,
        PaySystems::MONEYBOOKERS => array(
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 150000,
                'USD' => 5000,
                'EUR' => 3500,
            ),
        ),
        PaySystems::CASHU => array(
            'min' => array(
                'RUB' => 300,
                'USD' => 10,
                'EUR' => 10,
            ),
            'max' => array(
                'RUB' => 300000,
                'USD' => 10000,
                'EUR' => 7000,
            ),
        ),
        // ag: Add since #WTI-155
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
    ),
    AccountsTypes::MMA => AccountsTypes::MT4,
    AccountsTypes::TRANSAQ_USA => AccountsTypes::MT4,
    AccountsTypes::ECN => array(
        PaySystems::CREDIT_CARD => array(
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 100000,
                'USD' => 3000,
                'EUR' => 2000,
            ),
        ),
        PaySystems::CREDIT_CARD2 => array( // ad: #WHO-4844
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 30000,
                'USD' => 900,
                'EUR' => 600,
            ),
        ),
        PaySystems::CREDIT_CARD_RBK => array(
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'USD' => 2500,
                'EUR' => 2000,
                'RUB' => 100000
            ),
        ),
        PaySystems::CREDIT_CARD_NETBANX => array(
            'min' => array(
                'USD' => 100,
                'EUR' => 100,
            ),
        ),
        PaySystems::PAYZA => array(
            'min' => array(
                'USD' => 100,
                'EUR' => 100,
            ),
        ),
        PaySystems::ONPAY => array( // ad: #WTT-706
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 15000,
                'USD' => 400,
                'EUR' => 300,
            ),
        ),
        PaySystems::QIWI_WALLET => PaySystems::ONPAY,
        PaySystems::MONEY_MAIL => PaySystems::ONPAY,
        PaySystems::MONEYBOOKERS => array(
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 150000,
                'USD' => 5000,
                'EUR' => 3500,
            ),
        ),
        PaySystems::CASHU => array(
            'min' => array(
                'RUB' => 3000,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 300000,
                'USD' => 10000,
                'EUR' => 7000,
            ),
        ),
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
        PaySystems::NETELLER => array(
            'min' => array(
                'USD' => 100,
                'EUR' => 100,
            ),
        ),
    ),
    // ag: Add since #WTI-146
    AccountsTypes::MUSLIM => AccountsTypes::MT4,
    // ad: since #WTT-352
    AccountsTypes::RRM => array(
        PaySystems::CREDIT_CARD => array(
            'min' => array(
                'RUB' => 5500,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 100000,
                'USD' => 3000,
                'EUR' => 2000,
            ),
        ),
        PaySystems::QIWI_WALLET => array(
            'min' => array(
                'RUB' => 5500,
                'USD' => 100,
                'EUR' => 100,
            ),
            'max' => array(
                'RUB' => 15000,
                'USD' => 400, // ad: #WTT-706
                'EUR' => 300,
            ),
        ),
        PaySystems::PSB_WALLET => array( // ad: rewritten from wt-wallet #WTT-992
            'min' => array(
                'RUB' => 5500,
                'USD' => 100,
            ),
        ),
        PaySystems::CREDIT_CARD_RBK => array( // ad: #WTT-992
            'min' => array(
                'RUB' => 5500,
                'USD' => 100,
                'EUR' => 100,
            ),
        ),
        PaySystems::CREDIT_CARD_NETBANX => array( // ad: #WTT-992
            'min' => array(
                'USD' => 100,
                'EUR' => 100,
            ),
        ),
    ),
    AccountsTypes::FOREX_LIGHT => array(
        PaySystems::CREDIT_CARD => array(
            'max' => array(
                'RUB' => 100000,
                'USD' => 3000,
                'EUR' => 2000,
            ),
        ),
        PaySystems::DENGIONLINE => array( // ad: #WTT-706
            'max' => array(
                'RUB' => 15000,
                'USD' => 400,
                'EUR' => 300,
            ),
        ),
        PaySystems::ONPAY => PaySystems::DENGIONLINE, // ad: #WTT-903
        PaySystems::MONEYBOOKERS => array(
            'max' => array(
                'USD' => 5000,
            ),
        ),
        PaySystems::CASHU => array(
            'max' => array(
                'USD' => 10000,
            ),
        ),
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
    ),
    AccountsTypes::FME => array(),
    AccountsTypes::ROX => array(),
    AccountsTypes::XETRA => array(),
    AccountsTypes::EXOTIC_OPTIONS => array(
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
    ),
    AccountsTypes::NON_EXCHANGE_OPTIONS => array(
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
    ),
    AccountsTypes::TRADE_REPEATER => array(
        PaySystems::SBR_ONLINE => array(
            'max' => array(
                'RUB' => 30000,
            )
        ),
    ),
);

// ad: use $this->getPaymentsEmailsByGroupCase() to correctly process this config #WHO-4573
$this->paymentsProcessingSystem['emails_notify'] = array(
    'core' => array(
        'dvorobiev@corp.finam.ru',
        'adubov@corp.finam.ru',
        'dshkuratov@corp.finam.ru',
    ),
    'whotrades' => array(
        'logaa@corp.finam.ru',
        'money@finam.eu',
        'fail' => array(
            'sos+cash-out-fail@whotrades.org',
        ),
    ),
    'whotrades-sh' => array(
        '_FLClientsFunds@corp.finam.ru',
        'logaa@hushmail.com',
        'seychell@hushmail.com',
        'fail' => array(
            'sos+cash-out-fail@whotrades.org',
        ),
    ),
    'webinars' => array(
        'webinar@corp.finam.ru',
        'fail' => array(
            'weberrors@corp.finam.ru' // vdm: еще добавили разработчиков
        ),
    ),
    'exotic-options' => array(
        '_Money_Seychell@corp.finam.ru',
        'support@whotrades.info', // #WTI-302 by dmsh
    ),
    'non-exchange-options' => array(
        '_Money_Seychell@corp.finam.ru',
    ),
    'trade-repeater' => array(
        '_Money_Seychell@corp.finam.ru',
        'support@whotrades.info', // #WTI-302 by dmsh
    ),
    // ad: WtWallet through PSB since #WTT-367
    'wt-wallet' => array(
        'zhilin@office.whotrades.eu',
        'lavrov@corp.finam.ru',
        // #WTT-449
        'sminkov@corp.finam.ru',
        'vfomicheva@corp.finam.ru', // Фомичева В.В.
        'Lfedorova@corp.finam.ru', // Федорова Л.В.
    ),
    // ad: example for #WHO-4125
    /*'Generic merchant #1' => array(
        'success' => array(
            'adubov@corp.finam.ru'
        ),
        'fail' => array(
            'adubov@corp.finam.ru'
        ),
    ),*/
    'FL' => array(
        'success' => array(
            'money@finam.eu'
        ),
    ),
    // ad: платежи непрошедшие или с непонятным статусом
    'status-failed-or-undefined-payments' => array(
        'vdm@whotrades.org',
    ),
);

$this->paymentsProcessingSystem['alwaysEnabledPaymentSystemPayerIdMap'] = array(
    // vdm: Мастербанк оставляем, хотя он итак включен для всех
    PaySystems::MASTERBANK => array(
    ),

    PaySystems::MONEYBOOKERS => array(
        15311282, // Dmitry Vorobyev
        461932303335, // Trader of Dmitry Vorobyev
        259232534, // Carleta Meyer aka Pavel Lvov
        461315037397, // Trader of Pavel Lvov
        321007292, // Pavel Lvov
        951418004, // Joe Tribiani aka Evgeniy Zhilin
        461032356298, // Trader of Evgeniy Zhilin
    ),
    PaySystems::QIWI => array(
        15311282, // Dmitry Vorobyev
        461932303335, // Trader of Dmitry Vorobyev
        259232534, // Carleta Meyer aka Pavel Lvov
        461315037397, // Trader of Pavel Lvov
        321007292, // Pavel Lvov
        951418004, // Joe Tribiani aka Evgeniy Zhilin
        461032356298, // Trader of Evgeniy Zhilin
    ),
    PaySystems::ONPAY => array(
        15311282, // Dmitry Vorobyev
        461932303335, // Trader of Dmitry Vorobyev
        259232534, // Carleta Meyer aka Pavel Lvov
        461315037397, // Trader of Pavel Lvov
        321007292, // Pavel Lvov
        951418004, // Joe Tribiani aka Evgeniy Zhilin
        461032356298, // Trader of Evgeniy Zhilin
    ),
    PaySystems::ALGOCHARGE => array(
        15311282, // Dmitry Vorobyev
        461932303335, // Trader of Dmitry Vorobyev
        259232534, // Carleta Meyer aka Pavel Lvov
        461315037397, // Trader of Pavel Lvov
        321007292, // Pavel Lvov
        951418004, // Joe Tribiani aka Evgeniy Zhilin
        461032356298, // Trader of Evgeniy Zhilin
    ),
    PaySystems::ASTECH => array(
        81563901, // linda_wlq@126.com
        461401415956, // Trader of linda_wlq@126.com
        490876320, // 1226433236@qq.com
        461713660359, // Trader 1226433236@qq.com
        259232534, // Carleta Meyer
        461315037397, // Trader Carleta Meyer
        951418004, // Joe Tribiani aka Evgeniy Zhilin
        461032356298, // Trader of Evgeniy Zhilin
    )
);

/*
    All payment systems static data
        agregators: bank, paypal, masterbank, payonline, moneybookers, qiwi, algocharge, onpay
        paymentType: banking, e-money, terminals, prepaid-cards, mobile-landline-payments
*/

$this->allPaymentSystemsStaticData = array(

    // ad: WtWallet through PSB since #WTT-367
    PaySystems::WT_WALLET_TEXT => array(
        'titleDicword' => 'page-top-up-account__finam-wallet',
        'agregator' => 'psb',
        'local_aggregator' => \PaymentsProcessingSystem\LocalAggregators::WTWALLET,
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__finam-wallet__desc',
        'withoutMin' => false,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => false
    ),
    // payment type — banking
    PaySystems::CREDIT_CARD_TEXT => array(
        'titleDicword' => 'page-top-up-account__credit-card',
        'agregator' => 'payonline',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__credit-card__desc',
        'withoutMin' => true,
        'separatePaymentNotes' => array('ecn' => array(), 'mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: credit-card / onpay #WHO-4844
    PaySystems::CREDIT_CARD2_TEXT => array(
        'titleDicword' => 'page-top-up-account__credit-card',
        'agregator' => 'onpay',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__credit-card__desc',
        'withoutMin' => true,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: credit-card / payU #WHO-4577
    PaySystems::CREDIT_CARD3_TEXT => array(
        'titleDicword' => 'page-top-up-account__credit-card',
        'agregator' => 'payu',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__credit-card__desc',
        'withoutMin' => false,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: credit-card / rbkmoney #WTT-724
    PaySystems::CREDIT_CARD_RBK_TEXT => array(
        'titleDicword' => 'page-top-up-account__credit-card-rbk',
        'agregator' => 'rbkmoney',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__credit-card-rbk__desc',
        'withoutMin' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('RUB', 'USD', 'EUR'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: credit-card / netbanx #WTT-825
    PaySystems::CREDIT_CARD_NETBANX_TEXT => array(
        'titleDicword' => 'page-top-up-account__credit-card-netbanx',
        'agregator' => 'netbanx',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__credit-card-netbanx__desc',
        'withoutMin' => false,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('USD', 'EUR'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: PSB #WTT-196
    PaySystems::PSB_WALLET_TEXT => array(
        'titleDicword' => 'page-top-up-account__psb-wallet',
        'agregator' => 'psb',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__psb-wallet__desc',
        'withoutMin' => false,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/mastercard.png',
                'textDicword' => 'master-card',
            ),
            array(
                'src' => '/site/blocks/payment-systems-logos/visa.png',
                'textDicword' => 'visa',
            ),
        ),
        'currencies' => array('USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => true
    ),
    PaySystems::CHINA_UNION_PAY_TEXT => array(
        'titleDicword' => 'page-top-up-account__china-union-pay',
        'agregator' => 'astech',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__china-union-pay__desc',
        'paymentNote' => 'payment_universal_note__china_union_pay',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/china-union-pay.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'CNY'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // ad: #WTI-156
    PaySystems::CHINA_UNION_PAY_INATEC_TEXT => array(
        'titleDicword' => 'page-top-up-account__china-union-pay-inatec',
        'agregator' => 'inatec',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__china-union-pay__desc',
        'paymentNote' => 'payment_universal_note__china_union_pay',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/china-union-pay.png',
            ),
        ),
        'currencies' => array('EUR', 'USD'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false, // lk: enable to all by zhilin request. 11/08/2014
    ),
    PaySystems::ALFA_BANK_TEXT => array(
        'titleDicword' => 'page-top-up-account__alfa-bank',
        'agregator' => 'onpay',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__alfa-bank__desc',
        'paymentNote' => 'payment_universal_note_alfa-bank',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/alfa-bank.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'fixCurrencyRate' => false, // ad: #WTI-247
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::BANK_TRANSFER_TEXT => array(
        'titleDicword' => 'page-top-up-account__bank-transfer',
        'agregator' => 'bank',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__bank-transfer__desc',
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/swift-currency-transfers.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => 'your-bank-fee',
        'period' => 'page-top-up-account__bank-transfer__period',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::SKRILL_TEXT => array(
        'titleDicword' => 'page-top-up-account__skrill-moneybookers',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__skrill-moneybookers__desc',
        'paymentNote' => 'payment_universal_note_skrill',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/skrill-moneybookers.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::GIROPAY_TEXT => array(
        'titleDicword' => 'page-top-up-account__giropay-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__giropay-skrill__desc',
        'paymentNote' => 'payment_universal_note_giropay',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/giropay-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '1.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::IDEAL_TEXT => array(
        'titleDicword' => 'page-top-up-account__ideal-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__ideal-skrill__desc',
        'paymentNote' => 'payment_universal_note_ideal',
        'paymentNoteCommissionHardcoded' => true, // ad: since #WHO-4549
        'withoutMin' => false,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/ideal-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::DANKORT_TEXT => array(
        'titleDicword' => 'page-top-up-account__dankort-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__dankort-skrill__desc',
        'paymentNote' => 'payment_universal_note_dankort',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/dankort-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '1.9%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::NORDEA_TEXT => array(
        'titleDicword' => 'page-top-up-account__nordea-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__nordea-skrill__desc',
        'paymentNote' => 'payment_universal_note_nordea',
        'paymentNoteCommissionHardcoded' => true, // ad: since #WHO-4549
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/nordea-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::POLI_TEXT => array(
        'titleDicword' => 'page-top-up-account__poli-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__poli-skrill__desc',
        'paymentNote' => 'payment_universal_note_poli',
        'paymentNoteCommissionHardcoded' => true, // ad: since #WHO-4549
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/poli-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::BOLETO_TEXT => array(
        'titleDicword' => 'page-top-up-account__boleto',
        'agregator' => 'algocharge',
        'paymentType' => array('banking'),
        'descriptionDicword' => 'page-top-up-account__boleto__desc',
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/boleto.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0-3%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => false
    ),
    PaySystems::FASAPAY_TEXT => array(
        'titleDicword' => 'page-top-up-account__fasapay',
        'agregator' => 'fasapay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__fasapay__desc',
        'paymentNote' => 'payment_universal_note_fasapay',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => false,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/fasapay.png',
            ),
        ),
        'currencies' => array('USD', 'IDR'),
        'commission' => '0.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    // payment type — e-money
    PaySystems::LIBERTY_RESERVE_TEXT => array(
        'titleDicword' => 'page-top-up-account__liberty-reserve',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__liberty-reserve__desc',
        'paymentNote' => 'payment_universal_note_liberty-reserve',
        'paymentNoteCommissionHardcoded' => false,
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/liberty-reserve.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0.5%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => true
    ),
    PaySystems::CASHU_TEXT => array(
        'titleDicword' => 'page-top-up-account__cashu',
        'agregator' => 'astech',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__cashu__desc',
        'paymentNote' => 'payment_universal_note__cashu',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/cashu.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::QIWI_WALLET_TEXT => array(
        'titleDicword' => 'page-top-up-account__qiwi-wallet',
        'agregator' => 'qiwi',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__qiwi-wallet__desc',
		'paymentNote' => 'payment_universal_note_qiwi_wallet',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/qiwi.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'fixCurrencyRate' => false, // ad: #WTI-247
        'commission' => '2%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::WEBMONEY_TEXT => array(
        'titleDicword' => 'page-top-up-account__webmoney',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__webmoney__desc',
        'paymentNote' => 'payment_universal_note_webmoney',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/webmoney.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0.4%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::YANDEX_MONEY_TEXT => array(
        'titleDicword' => 'page-top-up-account__yandex-money',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__yandex-money__desc',
        'paymentNote' => 'payment_universal_note_yandex-money',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/yandex-money.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '2.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::RBK_MONEY_TEXT => array(
        'titleDicword' => 'page-top-up-account__rbk-money',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__rbk-money__desc',
        'paymentNote' => 'payment_universal_note_rbk-money',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/rbk-money.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '1.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => true
    ),
    PaySystems::LIQPAY_TEXT => array(
        'titleDicword' => 'page-top-up-account__liqpay',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__liqpay__desc',
        'paymentNote' => 'payment_universal_note_liqpay',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/liqpay.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::MONEY_MAIL_TEXT => array(
        'titleDicword' => 'page-top-up-account__money-mail',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__money-mail__desc',
        'withoutMin' => true,
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/money-mail.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '2.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::DENGI_MAIL_RU_TEXT => array(
        'titleDicword' => 'page-top-up-account__money-mail-ru',
        'agregator' => 'onpay',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__money-mailru__desc',
        'paymentNote' => 'payment_universal_note_money-mail-ru',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/money-mailru.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '2.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::P24_TEXT => array(
        'titleDicword' => 'page-top-up-account__p24-skrill',
        'agregator' => 'moneybookers',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__p24-skrill__desc',
        'paymentNote' => 'payment_universal_note_p24',
        'paymentNoteCommissionHardcoded' => false,
        'withoutMin' => true,
        'separatePaymentNotes' => array('mma' => array('paymentNote' => 'payment_universal_note_skrill', 'withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/p24-skrill.gif',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0.9%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::ABAGOOS_TEXT => array(
        'titleDicword' => 'page-top-up-account__abaqoos',
        'agregator' => 'algocharge',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__abaqoos__desc',
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/abaqoos.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0-3%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => false
    ),

    // payment type — terminals
    PaySystems::QIWI_TERMINALS_TEXT => array(
        'titleDicword' => 'page-top-up-account__qiwi-terminals',
        'agregator' => 'onpay',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__qiwi-terminals__desc',
		'paymentNote' => 'payment_universal_note_qiwi_terminals',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/qiwi.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::ELEXNET_TEXT => array(
        'titleDicword' => 'page-top-up-account__elexnet',
        'agregator' => 'onpay',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__elexnet__desc',
        'paymentNote' => 'payment_universal_note_elexnet',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/elexnet.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '2%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::EUROSET_TEXT => array(
        'titleDicword' => 'page-top-up-account__euroset',
        'agregator' => 'onpay',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__euroset__desc',
        'paymentNote' => 'payment_universal_note_euroset',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/euroset.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '1.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::SVYAZNOY_TEXT => array(
        'titleDicword' => 'page-top-up-account__svyaznoy',
        'agregator' => 'onpay',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__svyaznoy__desc',
        'paymentNote' => 'payment_universal_note_svyaznoy',
        'paymentNoteCommissionHardcoded' => false,
        'separatePaymentNotes' => array('mma' => array('withoutMax' => true)), // ad: #WTI-71
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/svyaznoy.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '1.5%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::UKASH_TEXT => array(
        'titleDicword' => 'page-top-up-account__ukash',
        'agregator' => 'astech',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__ukash__desc',
        'paymentNote' => 'payment_universal_note__ukash',
        'paymentNoteCommissionHardcoded' => false,
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/ukash.png',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => true
    ),
    PaySystems::PAYPAL_TEXT => array(
        'titleDicword' => 'page-top-up-account__paypal',
        'agregator' => 'dengionline',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__paypal__desc',
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/paypal.png',
                'textDicword' => 'paypal',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => true
    ),
    PaySystems::CONTACT_TEXT => array(
        'titleDicword' => 'page-top-up-account__contact',
        'agregator' => 'dengionline',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__contact__desc',
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/contact.png',
                'textDicword' => 'paypal',
            ),
        ),
        'currencies' => array('RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => false
    ),
    PaySystems::SBR_ONLINE_TEXT => array(
        'titleDicword' => 'page-top-up-account__sbr_online',
        'agregator' => 'onpay',
        'paymentType' => array('terminals'),
        'descriptionDicword' => 'page-top-up-account__sbr_online__desc',
        'withoutMin' => true,
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/sbr_online.png',
                'textDicword' => 'sbr_online',
            ),
        ),
        'currencies' => array('EUR', 'USD', 'RUB'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => false,
        'hidden'    => true
    ),
    // ad: payza #WTI-138
    PaySystems::PAYZA_TEXT => array(
        'titleDicword' => 'page-top-up-account__payza',
        'agregator' => 'payza',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__payza__desc',
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/payza3.png',
                'textDicword' => 'payza',
            ),
        ),
        'currencies' => array('USD', 'EUR'),
        'commission' => '2%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),
    PaySystems::NETELLER_WALLET_TEXT => array(
        'titleDicword' => 'page-top-up-account__neteller_wallet',
        'agregator' => 'neteller',
        'paymentType' => array('e-money'),
        'descriptionDicword' => 'page-top-up-account__neteller_wallet__desc',
        'withoutMin' => false,
        'separatePaymentNotes' => array('ecn' => array('withoutMax' => true), 'mma' => array('withoutMax' => true)),
        'pictures' => array(
            array(
                'src' => '/site/blocks/payment-systems-logos/neteller-wallet.png',
                'textDicword' => 'neteller',
            ),
        ),
        'currencies' => array('USD', 'EUR'),
        'commission' => '0%',
        'period' => 'instantly',
        'available' => true,
        'hidden'    => false
    ),

    /* template:
    '' => array(
        'titleDicword' => 'payment_system_%_title',
        'agregator' => '',
        'paymentType' => array(''),
        'descriptionDicword' => 'payment_system_%_desc',
        'pictures' =>  array(
            array(
                'src' => '/site/blocks/payment-systems-logos/ .png',
            ),
        ),
        'currencies' => array(''),
        'commission' => '',
        'period' => '',
        'available' => ,
    ),
    */
);

// ad: #WHO-4385
$this->paymentsProcessingSystem['developers_person_limit_min'] = array(
    'RUB' => 0.01,
    'USD' => 0.01,
    'EUR' => 0.01,
    'IDR' => 1000,
    'CNY' => 0.1,
);

// bn: @since #WTT-87
$this->paymentsProcessingSystem['paymentsProcessingTroubleExists'] = false;
// dicword to show on payments screen
$this->paymentsProcessingSystem['paymentsProcessingTroubleMessage'] = 'payments_processing__trouble_message';

// ad: MUST BE THE LAST ASSIGNMENT IN THIS CONFIG!!! make 'allPaymentSystemsStaticData' section available inside PS config $this->paymentsProcessingSystem
$this->paymentsProcessingSystem['allPaymentSystemsStaticData'] = $this->allPaymentSystemsStaticData;

// last line
