<?php
/**
 * DeploYii - TestCommand
 *
 * @link https://github.com/giovdk21/deployii
 * @copyright Copyright (c) 2014 Giovanni Derks
 * @license https://github.com/giovdk21/deployii/blob/master/LICENSE
 */

namespace buildScripts\commands;

use app\lib\BaseCommand;
use app\lib\TaskRunner;
use Yii;

class TestCommand extends BaseCommand {

    public static function run(& $cmdParams, & $params) {

        $res = true;

        TaskRunner::$controller->stdout('Running Test Command');

        TaskRunner::$controller->stdout("\n");
        return $res;
    }

}
