<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyActivityReply extends Model
{
    protected $fillable = [
        'daily_activity_id',
        'user',
        'description',
        'created_by',
        'is_read',
    ];

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'user');
    }
}
