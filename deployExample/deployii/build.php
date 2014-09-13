<?php

use yii\helpers\Console;

return [

    'deployiiVersion' => '0.5.0',

    'require'         => [
        'sftpConnect--command',
        'git--command',
    ],

    'params'          => [
    ],

    'targets'         => [

        // init the project locally
        'init' => [
            // ...
        ],

        'default' => [
            ['target', 'fetch'],
            ['target', 'prepare'],
            ['target', 'test'],
            ['target', 'package'],
            ['target', 'deploy'],
        ],

        'clean' => [
            ['rmdir', '@buildScripts/build'],
        ],

        // download the Yii 2 basic app into the build directory; this is just for the sake of this
        // example as you would usually prepare the build from the source in your workspace.
        'fetch' => [
            ['target', 'clean'],
            ['git', 'clone', 'https://github.com/yiisoft/yii2-app-basic.git', '@buildScripts/build', [
                'depth' => 1,
            ]],
            ['rmdir', '@buildScripts/build/.git'],
        ],

        'test' => [
            ['out', 'Hopefully one day this will be running some automated tests...', Console::FG_CYAN],
        ],

        'prepare' => [
            ['out', 'At this point we should also run composer...', Console::FG_BLUE],
            [
                'replaceInFiles',
                ['index.php'],
                [
                    ['defined\(\'YII_DEBUG\'\)', "// defined('YII_DEBUG')", 'i'],
                    ['define\(\'YII_ENV\', \'(\w+)\'\);', "define('YII_ENV', '{{environment}}');", 'i'],
                ],
                '@buildScripts/build/web',
            ],
        ],

        'package' => [
            ['rm', '@buildScripts/build/web/index-test.php'],
            ['rm', '@buildScripts/build/composer.json'],
            ['rm', '@buildScripts/build/requirements.php'],
            ['rm', '@buildScripts/build/yii'],
            ['rm', '@buildScripts/build/yii.bat'],
            ['rmdir', '@buildScripts/build/tests'],
            ['compress', '@buildScripts/build', '@buildScripts/build/build.tar'],
        ],

        // backup online files & database
        'backup' => [
            ['out', 'Ideally we should perform a backup at this stage...', Console::FG_PURPLE],
        ],

        'deploy' => [
            ['target', 'backup'],
            ['sftpConnect', 'sftp1'],
            ['sftpMkdir', 'sftp1', 'private'],
            ['sftpChdir', 'sftp1', 'private'],
            ['sftpPut', 'sftp1', 'build.tar.gz', '.', '@buildScripts/build', true],
            ['sftpExec', 'sftp1', 'tar', '-xzf build.tar.gz'],
            ['sftpExec', 'sftp1', 'rm', 'build.tar.gz'],
            ['sftpExec', 'sftp1', 'ls', '-lhA'],
            ['sftpDisconnect', 'sftp1'],
        ],

    ],

];
