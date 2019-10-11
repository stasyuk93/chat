<?php

namespace App\Services\WebSocketEvents;

use App\User;
use App\Repositories\UserRepository;

class unBanUser extends AbstractAdminWS
{
    public function handle($data)
    {
        if(!$this->isAdmin()) return;

        $user = User::find($data->user_id);

        if(!$user) return;

        $repository = new UserRepository();
        $repository->unBan($user);

        $this->connection->send(json_encode([
            'event' => 'unBan',
            'user_id' => $data->user_id
        ]));
    }

}
