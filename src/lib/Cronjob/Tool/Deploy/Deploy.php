<?php
declare(ticks = 1);
/**
 * @example dev/services/deploy/misc/tools/runner.php --tool=Deploy_Deploy -vv
 */
class Cronjob_Tool_Deploy_Deploy extends Cronjob\Tool\ToolBase
{
    /**
     * Use this function to get command line spec for cronjob
     * @return array
     */
    public static function getCommandLineSpec()
    {
        return array();
    }

    /**
     * Performs actual work
     */
    public function run(\Cronjob\ICronjob $cronJob)
    {
        $workerName = \Config::getInstance()->workerName;
        $commandExecutor = new CommandExecutor($this->debugLogger);
        
        file_put_contents(\Config::getInstance()->pid_dir."/{$workerName}_deploy.php.pid", posix_getpid());
        file_put_contents(\Config::getInstance()->pid_dir."/{$workerName}_deploy.php.pgid", posix_getpgid(posix_getpid()));

        $data = RemoteModel::getInstance()->getNextTask($workerName);

        if ($data) {
            $project = $data['project'];
            $taskId = $data['id'];
            $version = $data['version'];
            $release = $data['release'];
        } else {
            $this->debugLogger->message('No work');
            return;
        }

        pcntl_signal(SIGTERM, function($signal) use ($taskId, $version){
            $this->debugLogger->message("Cancelling...");
            RemoteModel::getInstance()->sendStatus($taskId, 'cancelled', $version);
            $this->debugLogger->message("Cancelled...");
            CoreLight::getInstance()->getFatalWatcher()->stop();
            exit($signal);
        });

        $projectDir = "/home/release/buildroot/$project-$version/var/pkg/$project-$version/";

        $currentOperation = "none";
        try {
            //an: Сигнализируем о начале работы
            $currentOperation = "send status 'building'";
            RemoteModel::getInstance()->sendStatus($taskId, 'building');

            //an: Собираем проект
            $command = "env VERBOSE=y bash bash/rebuild-package.sh $project $version $release $taskId ".Config::getInstance()->rdsDomain." ".Config::getInstance()->createTag." 2>&1";

            if (Config::getInstance()->debug) {
                $command = "php bash/fakeRebuild.php $project $version";
            }

            $currentOperation = "building";
            $text = $commandExecutor->executeCommand($command);

            //an: Сигнализируем все что собрали и начинаем раскладывать по серверам
            RemoteModel::getInstance()->sendStatus($taskId, 'built', $version);

            //an: Должно быть такое же, как в rebuild-package.sh
            $filename = "$projectDir/misc/tools/migration.php";
            $migrations = array();
            if (file_exists($filename)) {
                //an: Проект с миграциями
                foreach (array('pre', 'post') as $type) {
                    $command = "php $filename migration --type=$type --project=$project new 100000 --interactive=0";
                    $text = $commandExecutor->executeCommand($command);
                    if (preg_match('~Found (\d+) new migration~', $text, $ans)) {
                        //an: Текст, начиная с Found (\d+) new migration
                        $subtext = substr($text, strpos($text, $ans[0]));
                        $subtext = str_replace('\\', '/', $subtext);
                        $lines = explode("\n", str_replace("\r", "", $subtext));
                        array_shift($lines);
                        $migrations = array_slice($lines, 0, $ans[1]);
                        $migrations = array_map('trim', $migrations);
                    }
                    RemoteModel::getInstance()->sendMigrations($project, $version, $migrations, $type);
                }
            }


            $currentOperation = "installing";
            //an: Раскладываем собранный проект по серверам
            $command = "bash bash/deploy.sh install $project $version 2>&1";

            if (Config::getInstance()->debug) {
                $command = "php bash/fakeRebuild.php $project $version";
            }
            $text = $commandExecutor->executeCommand($command);

            //an: Отправляем новые сгенерированные /etc/cron.d конфиги
            $cronConfig = "";
            if (!Config::getInstance()->debug) {
                foreach (glob("$projectDir/misc/cronjobs/cronjob-*") as $file) {
                    $cronConfig .= "#       ".preg_replace('~^.*/~', '', $file)."\n\n";
                    $cronConfig .= file_get_contents($file);
                    $cronConfig .= "\n\n";
                }
            } elseif (file_exists("/home/an/cronjob-$project")) {
                $cronConfig = file_get_contents("/home/an/cronjob-$project");
            }
            RemoteModel::getInstance()->sendCronConfig($taskId, $cronConfig);

            //an: Сигнализируем все что сделали
            RemoteModel::getInstance()->sendStatus($taskId, 'installed', $version, $text);
            $currentOperation = "send status 'installed'";
        } catch (CommandExecutorException $e) {
            if ($e->getCode() == 66) {
                //an: Это генерит скрипт releaseCheckRules.php
                echo "Release rejected\n";
                RemoteModel::getInstance()->sendStatus($taskId, 'failed');
            } else {
                $text = $e->output;
                echo "\n=======================\n";
                $title = "Failed to execute '$currentOperation'";
                echo "$title\n";
                RemoteModel::getInstance()->sendStatus($taskId, 'failed', $version, $text);
            }
            return $e->getCode();
        } catch (Exception $e) {
            RemoteModel::getInstance()->sendStatus($taskId, 'failed', $version, $e->getMessage());
        }

    }
}
