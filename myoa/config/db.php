<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=myoasystems',
    'username' => 'produser',
    'password' => 'prod#user!123',
    'charset' => 'utf8',
    'tablePrefix' => 'oa_',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache'
];
