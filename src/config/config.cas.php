<?php
/**
 * Single sign-on options file
 */
$this->CASLoginLocationUrl = 'http://crm.whotrades.com/singlelogin/?client_id=%s&return_url=%s&hash=%s&token=%s';
$this->CASLogoutLocationUrl = 'http://crm.whotrades.com/singlelogout/?return_url=%s';
$this->CASAuthConfirmMethod = 'singleLoginConfirm';

// These keys MUST to be duplicated at application.ini in CRM project (search by word "secretKey")
// also in CMD project - in application.ini file (search CASSecretKeys word)
$this->CASSecretKeys = array(
        'crm' => '7w9bJKg09H_lkV#',
        'stm' => 'asf6Hl,djejUy68',
        'cmd' => '987asdhkHJGF3Jk',
        'phplogs' => 'n79kjhLh59UyeDlM',
);