<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [
        'title', 'body', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\tag', 'post_tags');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\like');
    }

    public function likes_count()
    {
        return $this->hasOne('App\Models\likes_count');
    }
}
