<?php
// bn: settings for grabbing detailed logs for performance and operations monitoring and analytics

// btp-daemon settings
$this->monitoring['daemon']['enabled'] = true;
$this->monitoring['daemon']['host'] = 'udp://btp-0-1.local';
$this->monitoring['daemon']['port'] = 22400;

// new btp-daemon
$this->monitoring['btp_daemon']['enabled'] = true;
$this->monitoring['btp_daemon']['host'] = 'udp://btp-0-1.local';
$this->monitoring['btp_daemon']['port'] =  22400;

// mongodb storage settings
$this->monitoring['storage']['enabled'] = true;
$this->monitoring['storage']['connection'] = 'mongodb://mgdb-0-1.stm.local,mgdb-0-2.stm.local';
$this->monitoring['storage']['db'] = 'btp_stat_logs';
$this->monitoring['storage']['env_prefix'] = '';
