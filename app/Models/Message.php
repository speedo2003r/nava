<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $body
 * @property int|null $room_id
 * @property int|null $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read mixed $user_name
 * @property-read \App\Models\Room|null $room
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @mixin \Eloquent
 */
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
