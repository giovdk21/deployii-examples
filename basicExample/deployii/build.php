<?php

use yii\helpers\Console;

$environments = [
  'local' => 'Local', 'dev' => 'Development', 'prod' => 'Production'
];

return [

  'deployiiVersion' => 0.1,

  'require' => [
  ],

  'params' => [
    'environments' => $environments,
    'username' => 'user',
  ],

  'targets' => [

    'default' => [
      ['target', 'init'],
    ],

    'clean' => [
      ['rm', '@workspace/index.php'],
      ['rm', '@workspace/config-local.php'],
    ],

    'init' => [
      ['prompt', 'username', 'What is your name?'],
      ['out', 'Welcome {{username}}!', Console::BOLD],
      ['out', 'Thank you for trying DeploYii :)', Console::FG_BLUE],
      ['exec', 'pwd'],
      ['confirm', 'doContinue', 'Do you wish to continue?', true],
      ['if', '($params["doContinue"])', [
        ['out', 'The environments array: {{environments}}', Console::FG_CYAN],
        ['select', 'selectedEnv', 'Select environment', $environments],
        ['copy', '@scripts/index-dist.php', '@workspace/index.php'],
        ['copy', '@scripts/app_config/{{selectedEnv}}.php', '@workspace/config-local.php'],
      ]],
    ],

  ],

];
