<?php

namespace App\Http\Controllers;

use App\Traits\WebSocketable;
use Exception;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocketController extends Controller implements MessageComponentInterface
{
    protected $clients;
    public $environment;

    use WebSocketable;

    /**
     * WebSocketController constructor.
     * @param $env
     */
    public function __construct($env)
    {
        parent::__construct();
        $this->clients = [];
        $this->environment = $env;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $host = $this->getHost($conn);

        if (empty($this->clients[$host])) {
            $this->clients[$host] = [];
        }

        $this->clients[$host][$conn->resourceId] = $conn;

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('New connection: ' . $conn->resourceId . ' (' . $host . ')');
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $host = $this->getHost($conn);

        unset($this->clients[$host][$conn->resourceId]);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Connection closed: ' . $conn->resourceId . ' (' . $host . ')');
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e)
    {
        debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
        $conn->close();
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        sleep(1);

        $host = $this->getHost($from);

        putenv('DOMAIN=' . $host);

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Document root: ' .  env('PUBLIC_PATH') . " " . 'DOMAIN: ' . env('DOMAIN'));
        }

        putenv('DOCUMENT_ROOT=' . env('PUBLIC_PATH'));

        $message = json_decode($msg, true);

        if (!$message) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('No JSON message supplied...');
            }

            $from->send($this->error('Не задано сообщение', null, 400, true));
        } else {
            if (empty($message['action'])) {

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('No action supplied...');
                }

                $from->send($this->error('Не задано событие (action)', null, 400, true));
            }

            if (empty($message['to'])) {

                if (env('APP_DEBUG_VARS') == true) {
                    debugvars('No to supplied...');
                }

                $from->send($this->error('Не задано кому (to)', null, 400, true));
            }
        }

        if (!empty($message['to'])) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Domain: ' . env('DOMAIN') . " " . 'To: ' . $message['to']);
            }
        }

        /** @var ConnectionInterface $client */
        foreach ($this->clients[$host] as $connectionId => $client) {

            if ($message['to'] == 'all') {
                $this->call($client, $from, $message);
            } else {
                if ($from !== $client) {
                    $this->call($client, $from, $message);
                }
            }
        }
    }

    private function getHost($conn)
    {
        $host = '0.0.0.0';

        if (property_exists($conn->WebSocket, 'request')) {
            $host = $conn->WebSocket->request->getHost();
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Host found ' . $host);
            }
        } else {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('No host found ' . $host);
            }
        }

        return $host;
    }
}