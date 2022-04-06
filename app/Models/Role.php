<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    protected $fillable = ['name_ar','name_en','name_ur'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this['name_' . lang()];
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
