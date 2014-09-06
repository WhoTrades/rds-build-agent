<?php
/**
 * @author Artem Naumenko
 * Тул генерирует cron.d конфиг на основании правил, описаных в файлах misc/cron/*.php
 */

/** @example dev/services/deploy/misc/tools/runner.php --tool=CodeGenerate_CronjobGenerator -vv --project=service-deploy --env=dev --server=1 */
class Cronjob_Tool_CodeGenerate_CronjobGenerator extends \Cronjob\Tool\ToolBase
{
    use \Cronjob\ConfigGenerator\GeneratorTool;
}
