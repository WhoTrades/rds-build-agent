<?php

// @see http://redis.io/topics/persistence
// lk: more persistent configuration, but not so fast. Store important business-data here.
$this->redis['server']['durable'] = array(
    'host' => 'rs-0-1.comon.local',
    'port' => 6380,
    'password' => '', //empty to no auth
    'timeout' => 2.0, //float, seconds. zero to no timeout
);

// lk: fast as deafult config, but coud loss data. Store only junk here :)
$this->redis['server']['fast'] = array(
    'host' => 'rs-0-1.comon.local',
    'port' => 6381,
    'password' => '',
    'timeout' => 2.0,
);
// HACK: lk: default is duarble, copy by reference to allow override in environment config
$this->redis['server']['default'] = &$this->redis['server']['durable'];

$this->cacheRedis['db']['default']['connection'] = &$this->redis['server']['fast'];

