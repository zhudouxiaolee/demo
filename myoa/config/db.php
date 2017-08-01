<?php

return [
    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=172.17.72.203;dbname=myoasystems',
//    'username' => 'oauser',
//    'password' => 'user#for!oa',
//    'username' => 'devuser',
//    'password' => 'dev#for!oa',
    'dsn' => 'mysql:host=localhost;dbname=myoasystems',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'tablePrefix' => 'oa_',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache'
];
