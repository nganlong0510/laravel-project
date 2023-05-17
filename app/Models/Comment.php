<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    /**
     * Get the Post of this comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
