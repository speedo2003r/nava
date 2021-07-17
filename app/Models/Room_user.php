<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room_user extends Model
{
    protected $fillable = [
        'room_id', 'user_id'
    ];
}
