<?php

$this->oauth['debug_mode'] = 0;

$this->oauth['auth_code_salt'] = 'Ak5k2()!5jo4lrdfldss-dg92lfkhm43os,l,fkki4o3';
$this->oauth['auth_access_token_salt'] = 'HJdhb2uo*O@boirb2lngsjdgo293fnskdnslfuw3t34=-23nw2k,,3nogi32';
$this->oauth['auth_refresh_token_salt'] = 'sdkjdsnguw9HU@otnn43N#LE!@)TKGSDPWNkeiodj2dnskopp;;4ngms;;23n234]';
$this->oauth['auth_token_expires_in'] = 604800;

$this->oauth['clients'] = array(
    'finam_ru' => array(
        'name' => 'Finam.Ru',
        'enabled' => true,
        'domains' => array('test.com', 'test2.com'),

        'secret' => '123123',
        'scope' => array('user_availability_real_accounts'),
    )
);