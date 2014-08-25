<?php
/**
 * @author Artem Naumenko
 *
 * Обновляет списки миграций в rds на основании реальных данных из существующих сборок
 */


require('config.php');
require('functions.php');

$projetDir = "/home/release/buildroot/";

$text = '';
try {
    foreach (glob($projetDir.'*') as $dir) {
        $dirName = preg_replace('~^.*/~', '', $dir);
        if (false === strpos($dirName, '-')) {
            continue;
        }
        list($project, $version) = explode('-', $dirName);

        //an: Должно быть такое же, как в rebuild-package.sh
        $filename = "$projetDir$project-$version/var/pkg/$project-$version//misc/tools/migration.php";
        $migrations = array();
        if (file_exists($filename)) {
            echo "Processing $project::$version\n";
            //an: Проект с миграциями
            foreach (array('pre', 'post') as $type) {
                $command = "php $filename migration --type=$type --project=$project new 100000 --interactive=0";
                $text = executeCommand($command);
                if (preg_match('~Found (\d+) new migration~', $text, $ans)) {
                    //an: Текст, начиная с Found (\d+) new migration
                    $subtext = substr($text, strpos($text, $ans[0]));
                    $subtext = str_replace('\\', '/', $subtext);
                    $lines = explode("\n", str_replace("\r", "", $subtext));
                    array_shift($lines);
                    $migrations = array_slice($lines, 0, $ans[1]);
                    $migrations = array_map('trim', $migrations);
                }

                RemoteModel::getInstance()->sendMigrations($taskId, $migrations, $type);
            }
        }
    }

} catch (CommandException $e) {
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
    exit($e->getCode());
} catch (Exception $e) {
    RemoteModel::getInstance()->sendStatus($taskId, 'failed', $version, $e->getMessage());
}
