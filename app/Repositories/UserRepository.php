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

    /**
     * @param User $user
     * @return User
     */
    public function mute(User $user)
    {
        $option = $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_mute' => true]);
        $user->userOption = $option;
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function unMute(User $user)
    {
        $option = $user->userOption = $user->userOption()->updateOrCreate(['user_id' => $user->id],['is_mute' => false]);
        $user->userOption = $option;
        return $user;
    }
}
