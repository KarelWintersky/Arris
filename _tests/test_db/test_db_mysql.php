<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Arris\AppLogger;
use Arris\DB;

$ENV = include '../../_env.php';
$ENV = $ENV['DB:MYSQL'];

try {
    AppLogger::init('test', 0 );
    AppLogger::addScope('mysql', [
        [ '_error.log', \Monolog\Logger::EMERGENCY ]
    ]);

    DB::init(NULL, $ENV, AppLogger::scope('mysql'));

    $n = DB::query("SHOW TABLES;")->fetchAll(PDO::FETCH_COLUMN);

    var_dump($n);

} catch (Exception $e) {
    echo 'Exception catched at global context: ', PHP_EOL, PHP_EOL;
    echo $e->getMessage(), PHP_EOL, PHP_EOL;
    echo $e->getTraceAsString();
    die;
}




