<?php

namespace App\Handlers;

use Workerman\Lib\Timer;

// 心跳间隔10秒
define('HEARTBEAT_TIME', 10);

class WorkermanHandler
{
    // 处理客户端连接
    public function onConnect($connection)
    {
        echo "new connection from ip " . $connection->getRemoteIp() . "\n".date('Y-m-d H:i:s')."\n";
    }

    // 处理客户端消息
    public function onMessage($connection, $data)
    {
        // 向客户端发送hello $data
        $connection->send('Hello, your send message is: ' . $data);
    }

    // 处理客户端断开
    public function onClose($connection)
    {
        echo "connection closed from ip {$connection->getRemoteIp()}\n" .date('Y-m-d H:i:s')."\n";
    }

    public function onWorkerStart($worker)
    {
            Timer::add(1, function()use($worker){
                foreach($worker->connections as $connection) {
                    $connection->send(date('Y-m-d H:i:s'));
                }
            });
        /*Timer::add(1, function () use ($worker) {
            $time_now = time();
            foreach ($worker->connections as $connection) {
                // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
                if (empty($connection->lastMessageTime)) {
                    $connection->lastMessageTime = $time_now;
                    continue;
                }
                // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
                if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                    echo "Client ip {$connection->getRemoteIp()} timeout!!!\n";
                    $connection->close();
                }
            }
        });*/
    }
}