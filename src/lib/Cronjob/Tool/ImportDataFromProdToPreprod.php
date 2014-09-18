<?php
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=ImportDataFromProdToPreprod -vv
 */

class Cronjob_Tool_ImportDataFromProdToPreprod extends Cronjob\Tool\ToolBase
{
    /** @var CommandExecutor */
    private $commandExecutor;

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

            $this->fixPostgresData();

            $this->clearBfs();
            $this->flushRedis();
            $this->flushMemcache();

            $this->openStorageAccess();
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

        $dir = dirname(dirname(dirname(__DIR__)))."/misc/tools/bash/";
        $command = "bash $dir/access_close.sh";
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
    }

    private function importMongo()
    {
        $this->debugLogger->info("[!] action=import_mongo");
    }

    private function fixPostgresData()
    {
        $this->debugLogger->info("action=fix_domain");
        $db = new RelationDB([
            'dsn' => \Config::getInstance()->DSN_DB1,
        ]);
        $db->getDbConnection()->executeQuery('update "group" set group_prefix=replace(group_prefix, \'whotrades.com\', \'wtpred.net\')');
        $db->getDbConnection()->executeQuery('update "group_domain" set gd_prefix=replace(gd_prefix, \'whotrades.com\', \'wtpred.net\')');

        $this->debugLogger->info("[!] action=clear_pgq_queues");

        $this->debugLogger->info("[!] action=fix_bfs, status='fix read/write units'");
        if (!\Config::getInstance()->debug) {
            $db->getDbConnection()->executeQuery('UPDATE storage_unit SET write_enable=false');
        }
    }
}
