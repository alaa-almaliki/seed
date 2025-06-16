<?php

declare(strict_types=1);

return [
    #=============================================================#
    # Connection, add your own database, username and password    #
    #=============================================================#
    'mysql' => [
        'driver' => 'Pdo_Mysql',
        'database' => 'sakila', // Database name is required
        'username' => 'sakila', // User is required
        'password' => 'sakila', // Password is required
        'hostname' => '127.0.0.1', // You can use localhost if you wish
        'port' => '3306', // port is always 3306 unless you want to make changes to the mariadb server
        'charset' => 'utf8mb4', // charset
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
            'payment'
        ],
    ],

    'sed' => [
        #=============================================================#
        # Execute find and replace see sample file                    #
        #=============================================================#

        "s,DEFINER=[^*]*\*,\*,g",
        "s,CREATE DEFINER=\`root\`@\`localhost\` FUNCTION,CREATE FUNCTION,g",
        "s,CREATE DEFINER=\`root\`@\`localhost\` PROCEDURE,CREATE PROCEDURE,g",
        "s,INSERT INTO,INSERT IGNORE INTO,g",
        "s,MySakila Drive,My Sakila Drive,g",
    ],

    'ddl' => [
        #=============================================================#
        # Execute insert into table                                   #
        #=============================================================#
        'insert' => [
            'address' => [
                [
                    'address' => '47 MySeed Drive',
                    'address2' => 'Seed Town',
                    'district' => 'Attika',
                    'city_id' => '38',
                    'postal_code' => '83579',
                    'phone' => '1234567890',
                    'last_update' => '2025-06-13 19:35:57',
                ],
            ]
        ],

        #=============================================================#
        # Execute update table                                        #
        #=============================================================#
        'update' => [
            'customer' => [
                [
                    'field' => 'first_name',
                    'value' => 'Seed',
                    'condition' => 'where customer_id = 1 limit 1',
                ],
            ],
        ],

        #=============================================================#
        # executes delete from table                                  #
        #=============================================================#
        'delete' => [
            'rental' => [
                'where rental_id  = 1 limit 1',
            ],
        ],

        #=============================================================#
        # Execute truncate table                                      #
        #=============================================================#
        'truncate' => [
            'film_text'
        ],

        #=============================================================#
        # Execute drop table                                          #
        #=============================================================#
        'drop' => [
            'language',
        ],
    ]
];