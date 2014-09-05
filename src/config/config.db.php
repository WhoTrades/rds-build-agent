<?php
/**
 * Конфигурационный файл для указания полюклчений к базе данных основного сервиса
 *
 * Должен подкючаться до остальных, т.к. они могут использовать значения из него
 */
$this->pg['pconnect']     = 0;

$this->DSN_DB1 = "pgsql://comon:rhfrflbkkj@pg-0-1.comon.local:5450/comon1";
$this->DSN_DB2 = "pgsql://comon:rhfrflbkkj@pg-0-2.comon.local:5450/comon2";
$this->DSN_DB3 = "pgsql://comon:rhfrflbkkj@pg-0-3.comon.local:5450/comon3";
$this->DSN_DB4 = "pgsql://comon:rhfrflbkkj@pg-0-4.comon.local:5450/comon4";

$this->DSN_DB1_RO    = $this->DSN_DB1;
$this->DSN_DB1_RO1   = $this->DSN_DB1;
$this->DSN_DB1_RO2   = $this->DSN_DB1;
$this->DSN_DB2_RO    = $this->DSN_DB2;
$this->DSN_DB3_RO    = $this->DSN_DB3;
$this->DSN_DB4_RO    = $this->DSN_DB4;

$this->cacheKvdpp['db']['default'] = array(
    'connection' => 'host=pg-0-3.comon.local port=5450 dbname=comon3 user=comon password=rhfrflbkkj',
);

$this->cacheCwkvdpp['db']['default'] = array(
    'connection' => 'host=pg-0-3.comon.local port=5450 dbname=comon3 user=comon password=rhfrflbkkj',
);

$this->DSN_SERVICES_FTENDER = "pgsql://ftender:rhfrflbkkj@pg-0-1.ftender.local:5450/ftender";


