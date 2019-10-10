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
        $repository = new UserRepository();
        $repository->ban($user);
        $this->ratchet->getClients()->detach($user);
    }
}
