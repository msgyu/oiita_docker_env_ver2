<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikesCount extends Model
{
    protected $fillable = [
        'likes_count'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
