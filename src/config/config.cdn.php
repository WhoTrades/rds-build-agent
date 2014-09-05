<?php
$this->cdn['use_cdn'] = true;
$this->cdn['use_host_without_cookie'] = true;
$this->cdn['without_cookies_domain'] = 'wtstatic.com';
$this->cdn['static_cdn_domain_prefix'] = array(
    'RU'  => 'ru',
    'CN' => 'zh',
    'SG' => 'zh'
);

$this->cdn['stat_url'] = '//stat-cdn.wtstatic.com/v1/cdn/pixel';

// Домены подходящие под паттерн не заменяются.
$this->cdn['exeption_host_pattern'] =  false; // '/^(x\d\d\.){0,1}(wtstatic.com)$/'; // Хак для ещё не прописанных доменов.(УЖЕ НЕ АКТУАЛЬНО)
