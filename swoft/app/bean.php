<?php

use App\Common\DbSelector;
use App\Process\MonitorProcess;
use Swoft\Db\Pool;
use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\SyncTaskListener;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;

return [
    'logger'           => [
        'flushRequest' => false,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer'       => [
        'class'    => HttpServer::class,
        'port'     => 9500,
        'listener' => [
            'rpc' => bean('rpcServer')
        ],
        'process' => [
//            'monitor' => bean(MonitorProcess::class)
        ],
        'on'       => [
//            SwooleEvent::TASK   => bean(SyncTaskListener::class),  // Enable sync task
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true
        ]
    ],
    'httpDispatcher'   => [
        // Add global http middleware
        'middlewares' => [
            // Allow use @View tag
            \Swoft\View\Middleware\ViewMiddleware::class,
        ],
    ],
    'db'               => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test;host=172.17.0.2',
        'username' => 'root',
        'password' => 'swoft123456',
    ],
    'db2'              => [
        'class'      => Database::class,
        'dsn'        => 'mysql:dbname=test2;host=172.17.0.2',
        'username'   => 'root',
        'password'   => 'swoft123456',
        'dbSelector' => bean(DbSelector::class)
    ],
    'db2.pool'         => [
        'class'    => Pool::class,
        'database' => bean('db2')
    ],
    'db3'              => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test2;host=172.17.0.2',
        'username' => 'root',
        'password' => 'swoft123456'
    ],
    'db3.pool'         => [
        'class'    => Pool::class,
        'database' => bean('db3')
    ],
    'migrationManager' => [
        'migrationPath' => '@app/Migration',
    ],
    'redis'            => [
        'class'    => RedisDb::class,
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
        'option' => [
            'prefix' => 'swoft:'
        ]
    ],
    'user'             => [
        'class'   => \App\Rpc\Client\Client::class,
        'host'    => '127.0.0.1',
        'serviceName'=> 'user',
        'port'    => 9508,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'client'             => [
        'class'   => App\Rpc\Client\Client::class,
        'host'    => '127.0.0.1',
        'serviceName'=> 'client',
        'port'    => 9505,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'pay'             => [
        'class'   => App\Rpc\Client\Client::class,
        'host'    => '39.96.196.246',
        'serviceName'=> 'pay',
        'port'    => 9508,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'live'             => [
        'class'   => App\Rpc\Client\Client::class,
        'host'    => '127.0.0.1',
        'serviceName'=> 'live',
        'port'    => 9508,
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'user.pool'        => [
        'class'  => ServicePool::class,
        'client' => bean('user')
    ],
    'pay.pool'        => [
        'class'  => ServicePool::class,
        'client' => bean('pay')
    ],
    'ConsulProvider'=> [
        'class'=>\App\Components\Consul\ConsulProvider::class,
    ],
    'rpcServer'        => [
        'class' => ServiceServer::class,
        'port'    => 9508,

    ],
    'wsServer'         => [
        'class'   => WebSocketServer::class,
        'port'    => 18308,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        'debug'   => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
        ],
    ],
    'tcpServer'         => [
        'port'  => 18309,
        'debug' => 1,
    ],
    /** @see \Swoft\Tcp\Protocol */
    'tcpServerProtocol' => [
        'type'            => \Swoft\Tcp\Packer\SimpleTokenPacker::TYPE,
        // 'openLengthCheck' => true,
    ],
    'cliRouter'         => [
        // 'disabledGroups' => ['demo', 'test'],
    ],

];
