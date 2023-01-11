<?php

namespace App\Traits;

use Ratchet\ConnectionInterface;

trait WebSocketable
{
    public function call(ConnectionInterface $client, ConnectionInterface $from, $message)
    {
        if (isset($message['action'])) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Message ' . $message['action'] . ' sent to: ' . $client->resourceId);
            }

            list($class, $action) = preg_split('/_/', $message['action']);

            $class = ucfirst($class);
            $classPath = 'App\Notifications\\' . $class;

            if (!class_exists($classPath)) {
                $from->send($this->error('Класс не найден', null, 400, true));
            } else {
                if (!method_exists($classPath, $action)) {
                    $from->send($this->error('Метод не найден', null, 400, true));
                } else {
                    $instance = new $classPath();
                    $instance->{$action}($client, $from, $message);
                }
            }
        }
    }
}