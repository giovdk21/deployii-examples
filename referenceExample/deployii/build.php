<?php

use yii\helpers\Console;

return [

    'deployiiVersion' => '0.5.0',

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
//            ['copyDir', 'source', '@workspace/dest', '@buildScripts'],
//            ['copyDir', 'aaa', '@workspace/dest', '@buildScripts'],

            ['copyDir', '@buildScripts/source_2', '@workspace/dest'],

            // this will print an error; see the second parameter:
            ['copyDir', ['source', 'test_{{test}}'], '@workspace/dest', '@buildScripts'],

//            ['copyDir', 'source', '@workspace/dest', '@buildScripts', [
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

        'compress' => [
            [
                'compress',
                ['source', '.gitignore', 'hello.txt', 'source_2/source_3'],
                '@buildScripts/build/archive.tar',
                '@buildScripts'
            ],
            [
                'compress',
                [
                    '@buildScripts/source',
                    '@buildScripts/.gitignore',
                    '@buildScripts/hello.txt',
                    '@buildScripts/source_2/source_3'
                ],
                '@buildScripts/build/archive2.tar'
            ],
            ['compress', '@buildScripts/source', '@buildScripts/build/archive3.tar'],
            ['compress', '@buildScripts/hello.txt', '@buildScripts/build/archive4.tar'],
            [
                'compress',
                ['source', '.gitignore', 'hello.txt', 'source_2/source_3'],
                '@buildScripts/build/archive5.tar',
                '@buildScripts',
                'gz',
                [
                    'filter' => function ($path) {
                            // only include files ending in .txt and directories
                            return (is_dir($path) || preg_match("/\\.txt$/i", $path) === 1);
                        }
                ]
            ],
            ['exec', 'ls', '-lh @buildScripts/build/'],
        ],

        'move' => [
//            ['rm', '@buildScripts/source_2/file_to_be_moved.php'],
            ['rmdir', '@buildScripts/source_2/dir_to_be_moved'],
            ['exec', 'touch', '@buildScripts/file_to_be_moved.php'],
            ['mkdir', '@buildScripts/dir_to_be_moved'],
            ['mkdir', '@buildScripts/dir_to_be_overwritten'],
            ['exec', 'touch', '@buildScripts/dir_to_be_overwritten/wont_be_overwritten.php'],
            ['mv', '@buildScripts/exists.not', '@buildScripts/file_to_be_moved.php'],
            ['mv', '@buildScripts/dir_to_be_moved', '@buildScripts/file_to_be_moved.php'],
            ['mv', '@buildScripts/file_to_be_moved.php', '@buildScripts/source_2'],
            ['mv', '@buildScripts/dir_to_be_moved', '@buildScripts/dir_to_be_overwritten', true],
            ['rm', '@buildScripts/dir_to_be_overwritten/wont_be_overwritten.php'],
            ['mv', '@buildScripts/dir_to_be_moved', '@buildScripts/dir_to_be_overwritten', true],
            ['mv', '@buildScripts/dir_to_be_overwritten', '@buildScripts/dir_to_be_moved'],
            ['mv', '@buildScripts/dir_to_be_moved', '@buildScripts/source_2'],
        ],

        'replace' => [
            ['rmdir', '@buildScripts/build'],
            ['copyDir', '@buildScripts/to_replace', '@buildScripts/build/replaced'],
            [
                'replaceInFiles',
                ['directory', 'file.php'],
                [
                    [
                        "'config_2'\\s*=>\\s*\\[([^\\]]*\\])",
                        "'config_2' => [\n         'my_param' => 'changed!',\n     ]",
                        'm' // multi-line
                    ],
                    ["'current_env'\\s*=>\\s*'#ENV#'", "'current_env' => 'local'", 'i'],
                    ['// {now}',  function ($matches) { return '// '.date('H:i:s'); }],
                ],
                '@buildScripts/build/replaced',
                [
                    'filter' => function ($path) {
                            // only include files ending in .php and directories
                            return (is_dir($path) || preg_match("/\\.php/i", $path) === 1);
                        }
                ]
            ],
        ],

    ],

];
