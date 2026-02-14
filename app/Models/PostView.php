<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    protected $fillable = [
        'post_id',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    /**
     * Get the post that owns the view.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that made the view.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
