<?php

use yii\helpers\Console;

$environments = [
  'local' => 'Local', 'dev' => 'Development', 'prod' => 'Production'
];

return [

  'deployiiVersion' => '0.2.0',

  'require' => [
    'test--recipe',
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
      ['recipe', 'test', 'clean'], // user defined recipe (clean target)
    ],

    'init' => [
      ['prompt', 'username', 'What is your name?'],
      ['out', 'Welcome {{username}}!', Console::BOLD],
      ['out', 'Thank you for trying DeploYii :)', Console::FG_BLUE],
      ['loadJson', '@buildScripts/stored.json', 'stored', [ // default values:
        'lastRunTimestamp' => 0,
        'lastRunDatetime'  => 'never',
      ]],
      ['if', '(time() - $params["stored_lastRunTimestamp"] > 30)', [
        ['out', 'You last run this task more than 30 seconds ago: {{stored_lastRunDatetime}}!'],
      ]],
      ['exec', 'pwd'],
      ['confirm', 'doContinue', 'Do you wish to continue?', true],
      ['if', '($params["doContinue"])', [
        ['out', 'The environments array: {{environments}}', Console::FG_CYAN],
        ['select', 'selectedEnv', 'Select environment', $environments],
        ['copy', '@buildScripts/index-dist.php', '@workspace/index.php'],
        ['copy', '@buildScripts/app_config/{{selectedEnv}}.php', '@workspace/config-local.php'],
        ['test'], // user defined command
        ['recipe', 'test'], // user defined recipe (default target)
      ],
      [ // else:
        ['out', '...you can run this script again; for more info see "deployii help run"'],
      ]],
      ['saveAsJson', '@buildScripts/stored.json', [
        'lastRunTimestamp' => time(),
        'lastRunDatetime'  => date('Y-m-d H:i:s'),
      ]],
    ],

  ],

];
