<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $appends = ['user_name'];
    protected $fillable = [
        'body', 'room_id', 'user_id','type','created_at','updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getUserNameAttribute()
    {
        return $this->user['name'];
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
}
