<?php

namespace App\Services\WebSocketEvents;

use App\Repositories\UserRepository;
use App\User;

class unMuteUser extends AbstractAdminWS
{
    public function handle($data)
    {
        if(!$this->isAdmin()) {
            return;
        }

        $user = User::find($data->user_id);

        if(!$user) {
            return;
        }

        $repository = new UserRepository();
        $user = $repository->unMute($user);
        $this->connection->send(json_encode([
            'event' => 'unMute',
            'user_id' => $data->user_id
        ]));
        $client = $this->ratchet->getClientByUserId($user->id);

        if(!$client) {
            return;
        }
        $client->user = $user;
        $client->send(json_encode([
            'event' => 'unMuteClient'
        ]));
    }
}
