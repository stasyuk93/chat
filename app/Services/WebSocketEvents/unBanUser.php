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
        $repository = new UserRepository();
        $repository->unBan($user);
    }

}
