<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'notizen' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=localhost;dbname=notizverwaltung',
                    'user'       => 'notizen',
                    'password'   => 'notizen',
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'notizen',
            'connections' => ['notizen']
        ],
        'generator' => [
            'defaultConnection' => 'notizen',
            'connections' => ['notizen']
        ]
    ]
];
