<?php

return [

    'default' =>  'sqlsrv',

   'connections' => [
        'sqlsrv' => [
            'driver'    => 'sqlsrv',
            'host'      => ('10.0.7.254'),
            'port'      => ('1433'),
            'database'  => ('BDATO_GENERAL'),
            'username'  => ('usuariokdev'),
            'password'  => ('adm75BD3k'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],
         'sqlSip' => [
            'driver'    => 'sqlsrv',
            'host'      => ('192.168.112.224'),
            'port'      => ('1433'),
            'database'  => ('BD_GM_DMS_CONCESIONARIO'),
            'username'  => ('sa'),
            'password'  => ('AdminpsW2200'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
         ],

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => ('190.113.12.11'),
            'port'      => ('3306'),
            'database'  => ('maestras'),
            'username'  => ('root'),
            'password'  => ('adminpsw22002200elneperiano'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
    ],
];