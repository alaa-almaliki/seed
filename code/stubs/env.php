<?php

declare(strict_types=1);

return [
    #=============================================================#
    # Connection, add your own database, username and password    #
    #=============================================================#
    'mysql' => [
        'driver' => 'Pdo_Mysql',
        'database' => '', // Database name is required
        'username' => '', // User is required
        'password' => '', // Password is required
        'hostname' => '127.0.0.1', // You can use localhost if you wish
        'port' => '3306', // port is always 3306 unless you want to make changes to the mariadb server
        'charset' => 'utf8', // charset
    ],

    #=============================================================#
    # Mysqldump options                                           #
    #=============================================================#
    'mysqldump' => [
        'options' => [
            '--routines',
            '--single-transaction',
            '--quick',
            '--no-tablespaces',
            '--skip-lock-tables',
        ],
        'exclude_tables' => [
//            'table_1',
//            'table_2',
//            'table_3',
        ],
    ],

    'sed' => [
        #=============================================================#
        # Execute find and replace see sample file                    #
        #=============================================================#

        #'1d',
        #"s,DEFINER=[^*]*\*,\*,g",
        #"s,^INSERT INTO,INSERT IGNORE INTO,g",
        #"s,www.live.com,www.local.test,g",
    ],

    'ddl' => [
        #=============================================================#
        # Execute insert into table                                   #
        #=============================================================#
        'insert' => [
//            'table_1' => [
//                [
//                    'field_1' => 'value_1',
//                    'field_2' => 'value_2',
//                    'field_3' => 'value_3',
//                    'field_...999' => 'value_...999'
//                ],
//                'table_2' => '...'
//            ]
        ],

        #=============================================================#
        # Execute update table                                        #
        #=============================================================#
        'update' => [
//            'table_1' => [
//                [
//                    'field_name' => 'field_1',
//                    'value' => '127.0.0.1',
//                    'condition' => 'where path = "acme.settings.allowed_ips" limit 1',
//                ],
//            ],
        ],

        #=============================================================#
        # executes delete from table                                  #
        #=============================================================#
        'delete' => [
//            'table_1' => [
//                // condition
//                'where ip  = "127.0.0.1" limit 1',
//            ],
        ],

        #=============================================================#
        # Execute truncate table                                      #
        #=============================================================#
        'truncate' => [
//            'table_1',
//            'table_2',
//            'table_3',
        ],

        #=============================================================#
        # Execute drop table                                          #
        #=============================================================#
        'drop' => [
//            'table_1',
//            'table_2',
//            'table_3',
        ],
    ]
];