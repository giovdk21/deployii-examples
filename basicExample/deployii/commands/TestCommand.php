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
use Yii;

class TestCommand extends BaseCommand {

    public function run(& $cmdParams, & $params) {

        $res = true;

        $this->controller->stdout('Running Test Command');
        $this->controller->stdout("\n");

        return $res;
    }

}
