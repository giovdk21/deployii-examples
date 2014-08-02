<?php

use yii\helpers\Console;

return [

    'deployiiVersion' => '0.3.0',

    'require'         => ['example--recipe'],

    'params'          => [
        'now'      => date('H:i:s'),
        'username' => 'user',
        'test'     => rand(100, 999),
    ],

    'targets'         => [

        'default' => [
            ['out', 'Please run a specific target'],
        ],

        'output'  => [
            ['out', 'Welcome!', Console::FG_YELLOW],
            ['out', 'It\'s {{now}}'],
        ],

        'input'   => [
            ['prompt', 'username', 'What is your name?'],
            ['confirm', 'yes_no', 'Yes or no?', true],
            ['select', 'abc', 'Select a letter', ['a' => 'A', 'b' => 'B', 'c' => 'C']],
        ],

        'recipes' => [
            ['recipe', 'example'],
        ],


        'log' => [
            ['saveLog', '@buildScripts/log/test.html', 'html'],
//            ['saveLog', '@buildScripts/log/test.html', 'html', true], // fourth param: append
        ],

        'copy_dir' => [
            // the copyDir command can be used in different ways:
            ['rmdir', '@workspace/dest/'],

//            ['copyDir', '@buildScripts', '@workspace/dest'],
//            ['copyDir', '@buildScripts/source', '@workspace/dest'],
//            ['copyDir', '@buildScripts', '@workspace/dest', 'source'],
//            ['copyDir', '@buildScripts', '@workspace/dest', 'aaa'],

            // this will print an error; see the fourth parameter:
            ['copyDir', '@buildScripts', '@workspace/dest', ['source', 'test_{{test}}']],

//            ['copyDir', '@buildScripts', '@workspace/dest', 'source', [
//                'except' => ['test1\.txt']
//            ]],
        ],

        'chmod' => [
            ['exec', 'touch', '@workspace/test_{{test}}.txt'],
            ['mkdir', '@workspace/test_dir_{{test}}'],
            ['chmod',
                [
                    0664   => ['@workspace/test_{{test}}.txt'],
                    '0700' => ['@workspace/test_dir_{{test}}'],
                ]
            ],
            ['exec', 'ls', '-ld @workspace/test*_{{test}}*'],
            ['rm', '@workspace/test_{{test}}.txt'],
            ['rmdir', '@workspace/test_dir_{{test}}'],
        ],

    ],

];
