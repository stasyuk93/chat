<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $with = ['roles','userOption'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Models\Role::class,'user_roles');
    }

    public function userOption()
    {
        return $this->hasOne(Models\UserOption::class);
    }

    /**
     * @return bool
     */
    public function isBanned(){
        if($this->userOption && $this->userOption->is_ban) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isMuted()
    {
        if($this->userOption && $this->userOption->is_mute) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        if($this->roles->isEmpty()) return false;
        foreach ($this->roles as $role){
            if($role->name == 'admin') return true;
        }
        return false;
    }

}
