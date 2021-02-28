<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $fillable = [
        'user_id', 'post_id'
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\post');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
