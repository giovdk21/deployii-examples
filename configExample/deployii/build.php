<?php

use yii\helpers\Console;

return [

    'deployiiVersion' => '0.5.0',

    'require'         => [],

    'params'          => [
        'dbUsername' => 'overwritten by config',
    ],

    'targets'         => [

        'default' => [
            ['out', 'Current environment: {{environment}}'],
            ['out', 'Configuration parameters are obfuscated:'],
            ['out', 'DB dsn: {{dbDsn}}'],
            ['out', 'DB username: {{dbUsername}}'],
            ['out', 'You can try this in non-interactive mode!', Console::FG_CYAN],
        ],

    ],

];
