<?php

namespace App\Services\WebSocketEvents;


class onClose extends AbstractWS
{
    public function handle($data = null)
    {
        foreach ($this->ratchet->getClients() as $client) {
            $client->send(json_encode([
                "event" => "onClose",
                "users" => $this->ratchet->getUsers(),
            ]));
        }
    }

}
