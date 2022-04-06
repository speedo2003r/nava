<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message_notification extends Model
{
    protected $fillable = [
        'message_id', 'room_id', 'is_seen','is_sender','flagged','is_delete','created_at','updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
    public function Message(){
        return $this->belongsTo('App\Models\Message');
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }
}
