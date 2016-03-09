<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=ImportDataFromProdToPreprod -vv
 */

use RdsSystem\lib\CommandExecutor;

class Cronjob_Tool_ImportDataFromProdToPreprod extends RdsSystem\Cron\RabbitDaemon
{
    const PROD_ENV_DETECTED_ERROR_CODE = 12;
    /** @var CommandExecutor */
    private $commandExecutor;

    private $bashDir;

    public static function getCommandLineSpec()
    {
        return array(
            'skip-postgres' => [
                'desc' => 'Не испортировать базу postgres',
                'valueRequired' => false,
            ],
            'skip-mongo' => [
                'desc' => 'Не испортировать базу mongodb',
                'valueRequired' => false,
            ],
            'sleep' => [
                'desc' => 'Время ожидания заверешения тулов на tl машине',
                'valueRequired' => true,
                'default' => 60,
            ],
        ) + parent::getCommandLineSpec();
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $model = $this->getMessagingModel($cronJob);
        $this->debugLogger->message("Preprod marked as down");
        $model->sendPreProdDown(new \RdsSystem\Message\PreProd\Down());

        $this->commandExecutor = new CommandExecutor($this->debugLogger);

        //an: Этот скрипт ни в коем случае нельзя запускать на проде, потому мы проверяем сервер, откуда скрипт запускается
        $hostname = $this->commandExecutor->executeCommand("hostname");
        if (false !== strpos($hostname, "nye-wt")) {
            $this->debugLogger->error("Running on prod server detected, exiting");
            return self::PROD_ENV_DETECTED_ERROR_CODE;
        }

        $this->bashDir = dirname(dirname(dirname(__DIR__)))."/misc/tools/bash/";

        $this->debugLogger->info("action=tools_work, status=stop");

        try {
            //an: Кто за минуту завершиться не успел - я не виноват :)
            //an: @todo сделать нормальный анализ работающих тулов по всем tl машинам
            $this->debugLogger->info("process=sleep, delay=".$cronJob->getOption('sleep')." seconds");
            sleep($cronJob->getOption('sleep'));

            $this->closeStorageAccess();

            if (!$cronJob->getOption('skip-postgres')) {
                $this->importPostgres();
            }

            if (!$cronJob->getOption('skip-mongo')) {
                $this->importMongo();
            }

            //an: тут часто соединение обрывается из-за очень большого времени выполнения импорта, потому реконнектимся
            $model->reconnect();

            $this->clearBfs();
            $this->flushRedis();
            $this->flushMemcache();

            $this->openStorageAccess();

            sleep(5);

            $this->fixPostgresData();
            //an: на самом деле releaseLock не нужен, так как мемкеш мы почистили, а флаг блокировки лежит там. Но для целостности логики я оставил тут этот оператор
            $this->debugLogger->info("action=tools_work, status=start");
        } catch (Exception $e) {
            $this->debugLogger->error("Unknown error occurred: ".$e->getMessage());
            $this->debugLogger->message($e->getTraceAsString());
            $this->openStorageAccess();
            $this->debugLogger->info("action=tools_work, status=start");

            $model->sendPreProdUp(new \RdsSystem\Message\PreProd\Up());
            $this->debugLogger->message("Preprod marked as online");

            throw $e;
        }

        $this->debugLogger->message("Successful imported data");

        $model->sendPreProdUp(new \RdsSystem\Message\PreProd\Up());
        $this->debugLogger->message("Preprod marked as online");
    }

    private function flushRedis()
    {
        $this->debugLogger->info("action=flush_redis");
        $config = \Config::getInstance()->redis['server'];
        foreach ($config as $val) {
            $redis = new \Redis();
            $redis->connect($val['host'], $val['port'], $val['timeout']);
            $redis->flushAll();
        }
    }

    private function flushMemcache()
    {
        $this->debugLogger->info("action=flush_memcached");
        CoreLight::getInstance()->getServiceBaseCacheMemcached()->flush();
        $cmd = \Config::getInstance()->debug ? "ls -lh /" : "ssh mc-0-1.comon.local '/etc/init.d/memcached restart'";
        $this->commandExecutor->executeCommand($cmd);
    }

    private function clearBfs()
    {
        $this->debugLogger->info("[!] action=flush_BFS");
    }

    private function closeStorageAccess()
    {
        $this->debugLogger->info("action=storage_access, status=close");

        $command = "bash $this->bashDir/access_close.sh";
        if (\Config::getInstance()->debug) {
            $command = "ls /tmp";
        }
        $this->commandExecutor->executeCommand($command);
    }

    private function openStorageAccess()
    {
        $this->debugLogger->info("action=storage_access, status=open");

        $dir = dirname(dirname(dirname(__DIR__)))."/misc/tools/bash/";
        $command = "bash $dir/access_open.sh";
        if (\Config::getInstance()->debug) {
            $command = "ls /tmp";
        }
        $this->commandExecutor->executeCommand($command);
    }

    private function importPostgres()
    {
        $this->debugLogger->info("action=import_postgres");
        $command = "ssh fre-tstwt-db1.whotrades.net bash /opt/postgres-import.sh";
        if (\Config::getInstance()->debug) {
            $command = "ls /tmp";
        }
        $this->commandExecutor->executeCommand($command);
    }

    private function importMongo()
    {
        $this->debugLogger->info("action=import_mongo");
        $command = \Config::getInstance()->debug ? "echo crm.20140928" : "bash $this->bashDir/mongo_check.sh";

        $text = $this->commandExecutor->executeCommand($command);
        foreach (explode("\n", $text) as $line) {
            list($db, $date) = explode(".", $line);
            $this->debugLogger->info("action=import_mongo, db=$db");
            $command = \Config::getInstance()->debug ? "echo Restored $line $db" : "bash $this->bashDir/mongo_restore.sh $line $db";
            $text = $this->commandExecutor->executeCommand($command);
            $this->debugLogger->insane($text);
        }
    }

    private function fixPostgresData()
    {
        $this->debugLogger->info("action=fix_domain");
        $this->getConnection('DSN_DB1')->executeQuery('update "group" set group_prefix=replace(group_prefix, \'whotrades.com\', \'wtpred.net\')');
        $this->getConnection('DSN_DB1')->executeQuery('update "group_domain" set gd_prefix=replace(gd_prefix, \'whotrades.com\', \'wtpred.net\')');

        $this->debugLogger->info("action=clear_pgq_queues");
        foreach (['DSN_DB1', 'DSN_DB2', 'DSN_DB3', 'DSN_DB4', 'DSN_SERVICES_FTENDER'] as $val) {
            //an: Очистка pgq
            if (!\Config::getInstance()->debug) {
                $this->getConnection($val)->executeQuery("UPDATE pgq.subscription SET sub_batch=null, sub_next_tick=null, sub_last_tick=(select max(tick_id) from pgq.tick where tick_queue=sub_queue)");
            } else {
                $this->getConnection($val)->executeQuery("SELECT VERSION()");
            }
        }

        $this->debugLogger->info("Clearing phplogs.logs");
        $this->getConnection('DSN_DB4')->executeQuery("truncate table phplogs.logs");


        $this->debugLogger->info("action=fix_bfs, status='fix read/write units'");
        if (!\Config::getInstance()->debug) {
            $db = new \DbFunc\ConnectionManager(
                $this->debugLogger,
                ['dsn' => \Config::getInstance()->DSN_DB1,]
            );
            $db->getDbConnection()->executeQuery('UPDATE storage_unit SET write_enable=false');

            $db->getDbConnection()->executeQuery("UPDATE storage_unit SET url=replace(url, 'storage1.comon.local', 'nye-wt-fs1.whotrades.net')");
            $db->getDbConnection()->executeQuery("UPDATE storage_unit SET url=replace(url, 'storage2.comon.local', 'nye-wt-fs2.whotrades.net')");
            $db->getDbConnection()->executeQuery("UPDATE storage_unit SET url=replace(url, 'storage3.comon.local', 'nye-wt-fs3.whotrades.net')");
            $db->getDbConnection()->executeQuery("UPDATE storage_unit SET url=replace(url, 'storage4.comon.local', 'nye-wt-fs4.whotrades.net')");
            $db->getDbConnection()->executeQuery("INSERT INTO public.storage_unit (unit_id, url, location, write_enable, read_enable, read_status, write_status) VALUES ('8', 'http://storage1.comon.local:10001', 'NYE', 't', 't', 't', 't')");
            $db->getDbConnection()->executeQuery("INSERT INTO public.storage_unit (unit_id, url, location, write_enable, read_enable, read_status, write_status) VALUES ('8', 'http://storage1.comon.local:10002', 'NYE', 't', 't', 't', 't')");
        }

        $this->debugLogger->message("Successful fixed postgres data");
    }

    /**
     * an: Этот метод позволяет не регистрировать тул в базе. А эта регистрация нам не нужна, так как по окончании работы тула база уже другая, и система сходит с ума при попытке разрегистрировать тул
     * @param $cacheDir
     * @return \Cronjob\InstanceManager\Single
     */
    static function getInstanceManager($cacheDir)
    {
        return new \Cronjob\InstanceManager\Dummy();
    }

    private function getConnection($dnsAlias)
    {
        return (new \DbFunc\ConnectionManager(
                $this->debugLogger,
                ['dsn' => \Config::getInstance()->$dnsAlias,]
        ))->getDbConnection();
    }
}
