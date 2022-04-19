<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message_notification
 *
 * @property int $id
 * @property int|null $message_id
 * @property int|null $room_id
 * @property int|null $user_id
 * @property int $is_seen
 * @property int $is_sender
 * @property int $flagged
 * @property int $is_delete
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Message|null $Message
 * @property-read \App\Models\Room|null $room
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereFlagged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereIsSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereIsSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message_notification whereUserId($value)
 * @mixin \Eloquent
 */
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
