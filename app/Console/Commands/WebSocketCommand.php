<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\ApiNotificationsController;
use App\Http\Controllers\WebSocketController;
use App\Http\Controllers\WebSocketPusherController;
use App\Utils\IoSecureServer;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class WebSocketCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:socket {--env=} {--domain=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start websocket daemon';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $env = $this->option('env');
        $domain = $this->option('domain');

        if ($env == 'production') {
            $port = config('app.ws.production');

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Production mode.');
            }

        } else {
            $port = config('app.ws.development');

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Development mode.');
            }
        }

        $secureOptions = [];

        if ($domain) {
            $cert = env('SSL_PATH') . DS . 'tls.crt';
            $key = env('SSL_PATH') . DS . 'tls.key';

            if (file_exists($cert) && file_exists($key)) {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('Key and cert for domain ' . $domain . ' exists');
                }
            } else {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('Cert not found for domain ' . $domain);
                }
            }
        } else {
            $domain = '0.0.0.0';
        }

        $controller = new WebSocketController($env);

        $server = IoSecureServer::factory(
            new HttpServer(
                new WsServer(
                    $controller
                )
            ), $port, $domain, $secureOptions
        );

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Websocket Daemon started successfully! Port ' . $port);
        }

        $server->run();
    }
}
