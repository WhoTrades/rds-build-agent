<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=ImportDataFromProdToPreprod -vv
 */

class Cronjob_Tool_ImportDataFromProdToPreprod extends Cronjob\Tool\ToolBase
{
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
        );
    }

    public function run(\Cronjob\ICronjob $cronJob)
    {
        $this->commandExecutor = new CommandExecutor($this->debugLogger);
        $this->bashDir = dirname(dirname(dirname(__DIR__)))."/misc/tools/bash/";

        $globalLock = \Cronjob\Factory::getGlobalLock($this->debugLogger);
        $this->debugLogger->info("action=tools_work, status=stop");
        $globalLock->acquireLock();

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

            $this->clearBfs();
            $this->flushRedis();
            $this->flushMemcache();

            $this->openStorageAccess();

            $this->fixPostgresData();
            //an: на самом деле releaseLock не нужен, так как мемкеш мы почистили, а флаг блокировки лежит там. Но для целостности логики я оставил тут этот оператор
            $this->debugLogger->info("action=tools_work, status=start");
            $globalLock->releaseLock();
        } catch (Exception $e) {
            $this->openStorageAccess();
            $this->debugLogger->info("action=tools_work, status=start");
            $globalLock->releaseLock();

            throw $e;
        }
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
    }

    private function clearBfs()
    {
        $this->debugLogger->info("[!] action=flush_BFS");
    }

    private function closeStorageAccess()
    {
        $this->debugLogger->info("action=storage_access, status=clos");

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
        $db = new \DbFunc\ConnectionManager(
            $this->debugLogger,
            ['dsn' => \Config::getInstance()->DSN_DB1,]
        );
        $db->getDbConnection()->executeQuery('update "group" set group_prefix=replace(group_prefix, \'whotrades.com\', \'wtpred.net\')');
        $db->getDbConnection()->executeQuery('update "group_domain" set gd_prefix=replace(gd_prefix, \'whotrades.com\', \'wtpred.net\')');

        $this->debugLogger->info("action=clear_pgq_queues");
        foreach (['DSN_DB1', 'DSN_DB2', 'DSN_DB3', 'DSN_DB4', 'DSN_SERVICES_FTENDER'] as $val) {
            $db = new \DbFunc\ConnectionManager(
                $this->debugLogger,
                ['dsn' => \Config::getInstance()->$val,]
            );

            //an: Очистка pgq
            if (!\Config::getInstance()->debug) {
                $db->getDbConnection()->executeQuery("UPDATE pgq.subscription SET sub_batch=null, sub_next_tick=null, sub_last_tick=(select max(tick_id) from pgq.tick where tick_queue=sub_queue)");
            } else {
                $db->getDbConnection()->executeQuery("SELECT VERSION()");
            }
        }


        $this->debugLogger->info("[!] action=fix_bfs, status='fix read/write units'");
        if (!\Config::getInstance()->debug) {
            $db = new \DbFunc\ConnectionManager(
                $this->debugLogger,
                ['dsn' => \Config::getInstance()->DSN_DB1,]
            );
            $db->getDbConnection()->executeQuery('UPDATE storage_unit SET write_enable=false');
            //$db->getDbConnection()->executeQuery('storage_unit SET write_enable=false');
        }
    }
}
