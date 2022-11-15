<?php

// autoload is not required, (Swoole comes from a PHP module)
// in php.ini : extension="openswoole.so"
$server = new Swoole\HTTP\Server('127.0.0.1', 9501);

$server->set([
    'worker_num' => 5, // We want 5 workers up and running
    // https://openswoole.com/docs/modules/swoole-server/configuration#dispatch_mode
    'dispatch_mode' => 1, // Uses the Round Robin algorithm to dispatch connections to workers
]);

// Triggered when new worker processes starts
$server->on('WorkerStart', function ($server, $workerId) {
    echo 'Worker starts:'.$server->getWorkerId().
    ' pid <'.$server->getWorkerPid().'>'.PHP_EOL;
});

$server->on('Start', function (Swoole\Http\Server $server) {
    echo 'Swoole http server is started at '.
    sprintf('http://%s:%s', $server->host, $server->port).
    PHP_EOL;
});

$server->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) use ($server) {
    $response->header('Content-Type', 'text/plain');
    $response->end('Hello World served by '.$server->getWorkerId());
});

// Starts the Swoole Server, it will create worker_num + 2 processes by default (Master, Manager, Workers)
// try to execute command: wrk http://127.0.0.1:9501/   -d10s
//
$server->start();
echo ' AFTER'.PHP_EOL;
