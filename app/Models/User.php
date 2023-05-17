<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get posts of this users.
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get comments of this users.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get comments of this users.
     */
    public function categories()
    {
        return $this->hasMany(Category::class)->orderBy('created_at', 'desc');
    }
}
