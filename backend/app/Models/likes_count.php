<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class likes_count extends Model
{
    protected $fillable = [
        'likes_count'
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\post');
    }
}
