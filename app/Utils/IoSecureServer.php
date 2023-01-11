<?php

namespace App\Utils;

use Ratchet\MessageComponentInterface;
use Ratchet\Server\IoServer;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\SecureServer as SecureReactor;
use React\Socket\Server as Reactor;


class IoSecureServer extends IoServer
{
    public static function factory(MessageComponentInterface $component, $port = 80,
                                   $address = '0.0.0.0', $secureOptions = [])
    {
        $loop = LoopFactory::create();

        $uri = 'tcp://';

        if (!empty($secureOptions)) {
            $uri = 'tls://';
        }

        $uri .= $address . ':' . $port . DS . 'socket';

        $socket = new Reactor($uri, $loop);

        if (!empty($secureOptions) && is_array($secureOptions)) {
            $socket = new SecureReactor($socket, $loop, $secureOptions);
        }

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Websocket Daemon uri: ' . $uri);
        }

        return new static($component, $socket, $loop);
    }
}