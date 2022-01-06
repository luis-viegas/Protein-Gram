<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps  = true;

    protected $table = "posts";

    /**
     * The user this card belongs to
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
