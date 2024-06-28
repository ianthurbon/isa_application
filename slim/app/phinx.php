<?php

declare(strict_types=1);
// load our environment files - used to store credentials & configuration

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}
if (!defined('START_TIME')) {
    // calculate script execution time with sprintf("%.2fs", microtime(true) - START_TIME);
    define('START_TIME', microtime(true));
}
Dotenv\Dotenv::createMutable(__DIR__.'/..', ['.env'], false)->load();

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/../db/migrations',
            'seeds'      => '%%PHINX_CONFIG_DIR%%/../db/seeds',
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_environment'     => 'cushon_recruitment_scenario',
            'cushon_recruitment_scenario'                    => [
                'adapter' => 'mysql',
                'host'    => $_ENV['DB_HOST'],
                'name'    => $_ENV['DB_NAME'],
                'user'    => $_ENV['DB_USER'],
                'pass'    => $_ENV['DB_PASS'],
                'port'    => $_ENV['DB_PORT'] ?? '3306',
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation',
    ];
