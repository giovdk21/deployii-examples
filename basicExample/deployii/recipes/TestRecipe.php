<?php
/**
 * DeploYii - TestRecipe
 *
 * @link https://github.com/giovdk21/deployii
 * @copyright Copyright (c) 2014 Giovanni Derks
 * @license https://github.com/giovdk21/deployii/blob/master/LICENSE
 */

use yii\helpers\Console;

return [

    'require' => ['example--recipe'],

    'params'  => [],

    'targets' => [
        'default' => [
            ['out', 'Just a test...', Console::FG_YELLOW],
            ['recipe', 'example'] // run built-in example recipe
        ],
        'clean' => [
            ['out', 'Testing the clear target of the recipe', Console::FG_PURPLE],
        ],
    ],

];
