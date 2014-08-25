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
        if (!preg_match('~^/?([\w-]+)-([\d.]+)/?$~', $dirName, $ans)) {
            continue;
        }
        list(, $project, $version) = $ans;

        if ($project == 'dictionary') {
            //an: В этом проекте чекаутится comon, но при этом нет миграций
            continue;
        }

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

                RemoteModel::getInstance()->sendMigrations($project, $version, $migrations, $type);
            }
        }
    }

} catch (CommandException $e) {
    exit($e->getCode());
}
