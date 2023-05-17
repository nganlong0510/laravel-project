<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['user_id', 'title', 'description'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'categories_posts', 'categories_id', 'posts_id');
    }

    /**
     * Get the format for serialization of dates.
     *
     * @return string
     */
    public function getDateFormatted(string $attribute, string $format)
    {
        return $this->$attribute->format($format);
    }
}
