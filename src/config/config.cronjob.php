<?php

// ad: this options MUST be (re-)defined in others configs, custom Config class or config.local.php of console tool
//     symlinks to config.cronjob.php & config.servicebase.php MUST be put in console tool config directory
//	   #WHO-3834

// is debug mode active? instance of site for tests (1), or it is production webserver (0)
$this->DEBUG_MODE = 0;

//$this->main_domain

//$this->cache_dir

// Dir for pid/lock files. Should be version-independent
$this->lock_dir = '/var/lib/cronjob';

// bash: to run cronjob tools
$this->allowed_users = array('apache', 'scheduler');

// zak: if this is set to true, all (supported) tools will check global lock on startup (see /misc/tools/release/acquire_global_lock.php)
//      global lock is set in the process of release and raised after it finishes
$this->global_cronjob_tool_lock_enabled = true;

// memcache settings
$this->memcached['servers'] = array(
    "mc-0-1.comon.local:11211",
);

// ad: #WHO-4586
$this->cronjob['repository'] = array(
    'dsn' => $this->DSN_DB4,
    'sync_period' => 60,
);

//$this->project
