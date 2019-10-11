<?php

namespace App\Services\WebSocketEvents;

use App\Repositories\UserRepository;
use App\User;

class banUser extends AbstractAdminWS
{
    public function handle($data)
    {
        if(!$this->isAdmin()) return;

        $user = User::find($data->user_id);

        if(!$user) return;

        $repository = new UserRepository();
        $repository->ban($user);
        $client = $this->ratchet->getClientByUserId($user->id);

        if(!$client) return;

        $this->ratchet->getClients()->detach($client);

        $client->close();

        $this->connection->send(json_encode([
            'event' => 'onBan',
            'user_id' => $data->user_id
        ]));
    }
}
