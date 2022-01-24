<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

use SmarterCoding\WpPlus\AppServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;

$appServiceProvider = new AppServiceProvider();
$appServiceProvider->boot();

global $wpdb;
$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => DB_HOST,
    'database' => DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASSWORD,
    'charset' => DB_CHARSET,
    'collation' => DB_COLLATE,
    'prefix' => $wpdb->prefix,
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
