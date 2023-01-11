<?php

namespace App\Notifications;


use App\Http\Controllers\Api\MenuController;

class Sections
{
    /**
     * @param $client
     * @param $from
     * @param null $message
     * @return mixed
     */
    public function update($client, $from = null, $message = null)
    {
        $data = app(MenuController::class)->index(true, true, $message['domain']);

        $data = json_decode($data, true);

        return $client->send(json_encode(['data' => $data, 'action' => 'menu_update']));
    }
}