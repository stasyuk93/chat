<?php

namespace App\Services\WebSocketEvents;

use App\User;

class getAllUsers extends AbstractAdminWS
{
    public function handle($data)
    {
        if(!$this->isAdmin()) {
            return;
        }
        $data = [
            'event' => 'showAllUsers',
            'users' => User::all()
        ];
        $this->connection->send(json_encode($data));
    }
}
