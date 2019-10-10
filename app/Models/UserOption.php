<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOption extends Model
{
    protected $fillable = [
        'is_ban',
        'is_mute',
        'user_id',
    ];
}
