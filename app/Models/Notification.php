<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    public $timestamps = false;

    /**
     * User who got the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * returns the Notification of a specific type that created this
     */
    public function notifiable()
    {
        return $this->morphTo('notifiable','type','id','id');
    }
}
