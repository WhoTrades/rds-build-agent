<?php
$text = <<<here

Yii Migration Tool v1.0 (based on Yii v1.1.14)

Found 2 new migrations:
    Y2014_2\m140804_120702_test
    Y2014_2\m140804_120703_test
here;

if (preg_match('~Found (\d+) new migration~', $text, $ans)) {
    //an: Текст, начиная с Found (\d+) new migration
    $subtext = substr($text, strpos($text, $ans[0]));
    $lines = explode("\n", str_replace("\r", "", $subtext));
    array_shift($lines);
    $migrations = array_slice($lines, 0, $ans[1]);
    $migrations = array_map('trim', $migrations);
    var_export($migrations);
}
