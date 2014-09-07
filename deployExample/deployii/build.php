<?php

use yii\helpers\Console;

return [

    'deployiiVersion' => '0.5.0',

    'require'         => [
        'sftpConnect--command'
    ],

    'params'          => [
    ],

    'targets'         => [

        'default' => [
            ['out', 'Available targets: test_sftp, test_ftp'],
            // the default target will be replaced with a proper example ;-)
        ],

        'test_sftp' => [
            ['sftpConnect', 'sftp1'],
//            ['sftpMkdir', 'sftp1', 'deployii_test/files'],
//            ['sftpList', 'sftp1', 'deployii_test/files'],
//            ['sftpMkdir', 'sftp1', 'deployii_test/test_perm'],
            ['sftpChdir', 'sftp1', 'deployii_test/files'],
//            ['sftpMkdir', 'sftp1', 'test_rmdir'],
//            ['sftpRmdir', 'sftp1', 'test_rmdir', true],
//            ['sftpList', 'sftp1'],
//            ['out', '{{sftp1.list}}'],
//            ['sftpChmod', 'sftp1', ['0700' => ['../test_perm']]],
            ['rmdir', '@buildScripts/build'],
            ['sftpRmdir', 'sftp1', 'build', true],
            ['copyDir', '@workspace', '@buildScripts/build', '', ['except' => ['deployii']]],
            [
                'sftpPut',
                'sftp1',
                ['build', 'test.txt'],
                '.',
                '@buildScripts',
                false
            ],
            ['sftpMkdir', 'sftp1', 'subdir'],
            [
                'sftpPut',
                'sftp1',
                '*',
                'subdir',
                '@buildScripts/build',
                false
            ],
            ['sftpRm', 'sftp1', 'subdir/stylesheets/sass/main.scss'],
//            ['sftpRm', 'sftp1', 'subdir/stylesheets/sass/main.scss'], // returns a warning
//            ['sftpRm', 'sftp1', 'subdir/stylesheets/sass'], // returns a warning
//            ['sftpRm', 'sftp1', 'subdir/stylesheets/sass/not_found.scss'], // returns a warning
            ['rmdir', '@buildScripts/downloaded'],
            ['mkdir', '@buildScripts/downloaded'],
            ['sftpGet', 'sftp1', 'subdir', '@buildScripts/downloaded'],
            ['sftpGet', 'sftp1', 'subdir/index.html', '@buildScripts/downloaded/index2.html'],
            ['sftpGet', 'sftp1', 'subdir/index.html', '@buildScripts/downloaded'], // skipped
//            ['sftpGet', 'sftp1', 'subdir', '@buildScripts/downloaded/index.html'], // returns a error
            ['sftpRm', 'sftp1', 'subdir/index2.html'],
            ['sftpMv', 'sftp1', 'subdir/index.html', 'subdir/index2.html'],
            // test sftpMv:
//            ['sftpMv', 'sftp1', 'subdir/index.html', 'subdir/index2.html', true], // returns error (not supported)
//            ['sftpMv', 'sftp1', 'subdir/aa', 'subdir/bb', true],
//            ['sftpMv', 'sftp1', 'subdir/cc', 'subdir/dd'],
//            ['sftpMv', 'sftp1', 'subdir/cc', 'subdir/dd'],
//            ['sftpMv', 'sftp1', 'subdir/dd', 'subdir/ee'],
//            ['sftpMv', 'sftp1', 'subdir/stylesheets', 'subdir/index2.html'],
            ['sftpExec', 'sftp1', 'ls', '-l subdir/'],
            ['sftpDisconnect', 'sftp1'],
        ],

        'test_ftp' => [
            ['sftpConnect', 'ftp1'],
            ['sftpChdir', 'ftp1', 'deployii_test/files'],
            ['sftpMkdir', 'ftp1', 'ftp_test'],
            ['sftpChdir', 'ftp1', 'ftp_test'],
            ['rmdir', '@buildScripts/build'],
            ['copyDir', '@workspace', '@buildScripts/build', '', ['except' => ['deployii']]],
            ['sftpRmdir', 'ftp1', 'build', true],
            [
                'sftpPut',
                'ftp1',
                ['build', 'test.txt'],
                '.',
                '@buildScripts',
                false
            ],
            ['sftpMkdir', 'ftp1', 'subdir'],
            [
                'sftpPut',
                'ftp1',
                '*',
                'subdir',
                '@buildScripts/build',
                false
            ],
            ['sftpRm', 'ftp1', 'subdir/stylesheets/sass/main.scss'],
            ['rmdir', '@buildScripts/downloaded_ftp'],
            ['mkdir', '@buildScripts/downloaded_ftp'],
            ['sftpGet', 'ftp1', 'subdir', '@buildScripts/downloaded_ftp'],
            ['sftpGet', 'ftp1', 'subdir/index.html', '@buildScripts/downloaded_ftp/index2.html'],
            ['sftpGet', 'ftp1', 'subdir/index.html', '@buildScripts/downloaded_ftp'], // skipped
//            ['sftpGet', 'ftp1', 'subdir', '@buildScripts/downloaded_ftp/index.html'], // returns a error
            ['sftpMkdir', 'ftp1', 'test_perm'],
            ['sftpChmod', 'ftp1', ['0700' => ['test_perm']]],
            ['sftpRm', 'ftp1', 'subdir/index2.html'],
            ['sftpMv', 'ftp1', 'subdir/index.html', 'subdir/index2.html'],
//            ['sftpExec', 'ftp1', 'touch', 'exec_worked'],
            ['sftpDisconnect', 'ftp1'],
        ],

    ],

];
