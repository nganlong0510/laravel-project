<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['title', 'description'];

    protected $dates = ['deleted_at'];

    /**
     * Get comments for a Post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_posts', 'posts_id', 'categories_id');
    }

    /**
     * Get the format for serialization of dates.
     *
     * @return string
     */
    public function serializeDate($date)
    {
        return $date->format('d/m/Y H:i:s');
    }


    // TODO: make this works for web.
    // public function save(array $options = array())
    // {
    //     // Always record current user id.
    //     if (!$this->user_id) {
    //         $this->user_id = Auth::user()?->id;
    //     }
    //     parent::save($options);
    // }
}
