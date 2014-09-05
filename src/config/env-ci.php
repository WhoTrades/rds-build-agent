<?php

$this->external_lib_dir = __DIR__ . '/../../pkg/';
$this->monitoring['daemon']['enabled'] = false;
$this->monitoring['storage']['enabled'] = false;

$this->redis['server']['durable']['host'] = 'rs-0-1.comon.local';
$this->redis['server']['durable']['port'] = 6379;
$this->redis['server']['fast']['port'] = 6379;

