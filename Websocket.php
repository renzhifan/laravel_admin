<?php
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;
use Workerman\Lib\Timer;

$worker = new Worker('websocket://0.0.0.0:2000');
// 设置transport开启ssl，websocket+ssl即wss
$worker->onMessage = function($con, $msg) {
    $con->send('hello'.$msg);
};


/*$worker = new Worker('websocket://0.0.0.0:2000');
// 进程启动后定时推送数据给客户端
$worker->onWorkerStart = function($worker){
    Timer::add(1, function()use($worker){
        foreach($worker->connections as $connection) {
            $connection->send(date('Y-m-d H:i:s'));
        }
    });
};*/


/*// 注意：这里与上个例子不同，使用的是websocket协议
$ws_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$ws_worker->count = 4;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{
    // 向客户端发送hello $data
    $connection->send('hello ' . $data);
};*/

// 运行worker
Worker::runAll();
