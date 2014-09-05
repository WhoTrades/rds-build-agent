<?php
/**
 * Конфигурационный файл для указания полюклчений к базе данных сервиса pgq.
 *
 * Должен подкючаться после остальных в которых может быть первчиное определение подключения к базе, т.к. свои значения не задает
 */
$this->PGQ_DSN_DB1 = $this->DSN_DB1;
$this->PGQ_DSN_DB2 = $this->DSN_DB2;
$this->PGQ_DSN_DB3 = $this->DSN_DB3;
$this->PGQ_DSN_DB4 = $this->DSN_DB4;

$this->PGQ_DSN_SERVICES_TASKS = $this->PGQ_DSN_DB3;
$this->PGQ_DSN_SERVICES_FTENDER = $this->DSN_SERVICES_FTENDER;
