<?php

namespace App\Models;

use App\Entities\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property int $private
 * @property string $type
 * @property int|null $order_id
 * @property int $user_id
 * @property int|null $other_user_id
 * @property int $last_message_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $DirectMessages
 * @property-read int|null $direct_messages_count
 * @property-read \App\Models\Message|null $LastMessage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message_notification[] $Messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $Owner
 * @property-read \App\Models\User|null $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $Users
 * @property-read int|null $users_count
 * @property-read Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereOtherUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUserId($value)
 * @mixin \Eloquent
 */
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
