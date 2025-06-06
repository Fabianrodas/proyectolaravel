<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'image',
        'is_private',
    ];

    protected $hidden = [
        'password',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    public function following() {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function conversations1() {
        return $this->hasMany(Conversation::class, 'user1_id');
    }

    public function conversations2() {
        return $this->hasMany(Conversation::class, 'user2_id');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }
}
