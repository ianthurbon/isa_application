<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$connections = [
    'default' => [
        'driver'    => 'mysql',
        'host'      => $_ENV['DB_HOST'] ?? '',
        'database'  => $_ENV['DB_NAME'] ?? '',
        'username'  => $_ENV['DB_USER'] ?? '',
        'password'  => $_ENV['DB_PASS'] ?? '',
        'port'      => $_ENV['DB_PORT'] ?? '3306',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ]
];

$capsule->addConnection($connections['default']);

$capsule->bootEloquent();
$capsule->setAsGlobal();
