<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Arris\AppLogger;
use Arris\DB;

$ENV = include '../../_env.php';
$ENV = $ENV['DB:PGSQL'];

try {
    AppLogger::init('test', 0 );
    AppLogger::addScope('pgsql', [
        [ '_error.log', \Monolog\Logger::EMERGENCY ]
    ]);

    DB::init(NULL, $ENV, AppLogger::scope('pgsql'));

DB::query("INSERT INTO t1 (code, name) VALUES (1, '55555')");

    $n = DB::query("SELECT * FROM t1;")->fetchAll();



    var_dump($n);

} catch (Exception $e) {
    echo 'Exception catched at global context: ', PHP_EOL, PHP_EOL;
    echo $e->getMessage(), PHP_EOL, PHP_EOL;
    echo $e->getTraceAsString();
    die;
}
