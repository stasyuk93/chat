<?php

namespace App\Repositories;
use App\User;

class UserRepository
{
    public function ban(User $user)
    {
        $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_ban' => true]);
    }

    public function unBan(User $user)
    {
        $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_ban' => false]);
    }

    public function mute(User $user)
    {
        $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_mute' => true]);
    }

    public function unMute(User $user)
    {
        $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_mute' => false]);
    }
}
