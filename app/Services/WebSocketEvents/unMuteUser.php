<?php

namespace App\Services\WebSocketEvents;

use App\Repositories\UserRepository;
use App\User;

class unMuteUser extends AbstractAdminWS
{
    public function handle($data)
    {
        if(!$this->isAdmin()) return;
        $user = User::find($data->user_id);
        $repository = new UserRepository();
        $repository->unMute($user);
    }
}
