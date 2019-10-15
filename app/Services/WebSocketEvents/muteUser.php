<?php

namespace App\Services\WebSocketEvents;

use App\Repositories\UserRepository;
use App\User;

class muteUser extends AbstractAdminWS
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
        $user = $repository->mute($user);
        $this->connection->send(json_encode([
            'event' => 'onMute',
            'user_id' => $data->user_id
        ]));
        $client = $this->ratchet->getClientByUserId($user->id);

        if(!$client) {
            return;
        }
        $client->user = $user;
        $client->send(json_encode([
            'event' => 'onMuteClient'
        ]));
    }
}
