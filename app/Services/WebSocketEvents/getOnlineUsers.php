<?php

namespace App\Services\WebSocketEvents;


class getOnlineUsers extends AbstractWS
{
    public function handle($data = null)
    {
        foreach ($this->ratchet->getClients() as $client) {
            $client->send(json_encode([
                'event' => 'getOnlineUsers',
                'users' => $this->ratchet->getUsers(),
            ]));
        }
    }

}
