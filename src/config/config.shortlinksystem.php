<?php

$this->shortLinkSystem['domainProtocol'] = 'http';
$this->shortLinkSystem['domain'] = 'whotrad.es'; //whotrad.es
$this->shortLinkSystem['fallbackUrl'] = 'http://whotrades.com/';

$this->shortLinkSystem['domainGo'] = 'whotrades.com/go';

$this->shortLinkSystem['convertRules'] = array(
    'groups_item_blog_post' => array(
        'prefix' => 'l',
        'id_permanent_start_with' => 43,
        'go_type' => 3,
        'length' => 11, //43037274862
        'object_id_param_name' => 'blog_post_id'
    ),
    'groups_item_charts_item' => array(
        'prefix' => 'j',
        'id_permanent_start_with' => 31,
        'length' => 11, //43037274862
        'go_type' => 8,
        'object_id_param_name' => 'chart_post_id'
    ),
);