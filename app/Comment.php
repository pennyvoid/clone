<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
