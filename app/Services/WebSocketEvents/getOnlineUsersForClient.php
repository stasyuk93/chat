<?php

namespace App\Services\WebSocketEvents;


class getOnlineUsersForClient extends AbstractWS
{
    public function handle($data = null)
    {

        $this->connection->send(json_encode([
            'event' => 'getOnlineUsers',
            'users' => $this->ratchet->getUsers(),
        ]));

    }

}
