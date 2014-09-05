<?php
if(!isset($dld)) {
    $dld = 'dev';
}

$this->dictionaryservice = array(
    'hasRealCopy' => true,
    'secretDctKey' => 'sdf1@#$!fsdfsafa',
    'mdrAuthUrl' => "http://mdr.{$dld}.whotrades.net/dictionary_create_token/create",
    'dctDicWordEditUrl' => "http://dct.{$dld}.whotrades.net/auth/token",
    'dctUrl' => "http://dct.{$dld}.whotrades.net/auth/token",
    'whotradesJsonRpcUrl' => "http://whotrades.{$dld}.whotrades.net/api/internal/systems/",
    'dct_tokens_kdvpp_key' => 'dct_auth_tokens',
    'tokenCreateUrl' => "http://dct.{$dld}.whotrades.net/auth/create",
    'dictionary_interval_notify_main' => strtotime('+30 minutes'),
    'dictionary_interval_notify_native' => strtotime('+30 minutes'),
    'dictionary_interval_notify_other' => strtotime('+30 minutes'),
    'dictionary_email_name' => 'Dictionary notification',
    'dictionary_email_notify_main_link' => "http://dct.{$dld}.whotrades.net/#/main_wait/",
    'dictionary_email_notify_native_link' => "http://dct.{$dld}.whotrades.net/#/native_wait/",
    'dictionary_email_notify_other_link' => "http://dct.{$dld}.whotrades.net/#/other_wait/",
    'dictionary_email_notify_main' => 'tt@whotrades.org, olpa+tst40214@whotrades.org, vlukasheva@corp.finam.ru',
    'dictionary_email_notify_native' => 'tt@whotrades.org, tt+main@whotrades.org, olpa+tst40214_3@whotrades.org',
    'dictionary_email_notify_other' => 'tt@whotrades.org, ddzhantaeva@corp.finam.ru, sdas@whotrades.eu, akhaddad@corp.finam.ru, akateshov@corp.finam.ru, manager_bj@gptoplearn.com, sdouba@corp.finam.ru, sfrauzel@corp.finam.ru, theng@whotrades.eu, mrianwiriyakit@whotrades.eu, omasaphan@whotrades.eu, dramirez@whotrades.eu, jalcala@whotrades.eu, khuang@whotrades.eu, achalermsuk@whotrades.eu, b.rattanachantranon@whotrades.eu, afekraoui@whotrades.eu, emikailova@corp.finam.ru, esilanteva@corp.finam.ru, asingh@whotrades.eu, rcao@whotrades.eu, a.x.wang@whotrades.eu, tvan@whotrades.eu, kdipak@whotrades.org, kmarwaha@whotrades.eu'
);

