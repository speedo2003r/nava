<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Room_user
 *
 * @property int $id
 * @property int|null $room_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room_user whereUserId($value)
 * @mixin \Eloquent
 */
class Room_user extends Model
{
    protected $fillable = [
        'room_id', 'user_id'
    ];
}
