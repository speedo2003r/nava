<?php

namespace App\Models;

use App\Entities\Order;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'type', 'order_id', 'user_id','private','other_user_id'
    ];

    // direct throw pivot table return users
    public function Users()
    {
        return $this->belongsToMany(User::class, 'room_users',
            'room_id', 'user_id');
    }

    // who create the room
    public function User(){
        return $this->belongsTo(User::class,'other_user_id','id');
    }
    // who create the room
    public function Owner(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    // who create the room
    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }

    // direct messages from messages table
    public function DirectMessages()
    {
        return $this->hasMany('App\Models\Message');
    }

    public function hasUser($user_id)
    {
        foreach ($this->Users as $user) {
            if($user->id == $user_id) {
                return true;
            }
        }
    }
    // get from message_notification table - where copy message for every room user
    public function Messages()
    {
        return $this->hasMany('App\Models\Message_notification')->with('Message');
    }

    public function LastMessage(){
        return $this->hasOne('App\Models\Message','id','last_message_id');
    }

    // public function Order(){
    //     return $this->belongsTo('App\Models\Order');
    // }
}
