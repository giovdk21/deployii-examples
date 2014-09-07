<?php

/**
 * Build script configuration file
 *
 * This file:
 * - is loaded by the task runner
 * - configuration is injected into the build parameters according to the selected environment
 * - is, by default, not committed to VCS (see .gitignore)
 * - configuration defined in this file will be obfuscated in the log and output
 */


return [

    'defaultEnvironment' => 'dev',
    'environments'       => ['dev' => 'Development', 'prod' => 'Production'],
    'config'             => [

        'common' => [ // default for every environment
            // ---
            // Default / SFTP connection config:
            'sftpHost'                => 'localhost',
            'sftpAuthMethod'          => 'key',
            'sftpUsername'            => 'testuser',
            'sftpKeyFile'             => '/home/username/.ssh/id_rsa',
            // ---
            // FTP connection (specific) config:
            'ftp1.sftpConnectionType' => 'ftp',
            'ftp1.sftpPort'           => '21',
            'ftp1.sftpPassword'       => '',
            'ftp1.sftpLabelColor'     => yii\helpers\Console::BG_PURPLE,
        ],
        'dev'    => [

        ],
        'prod'   => [

        ],

    ],

];