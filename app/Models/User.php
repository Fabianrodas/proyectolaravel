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

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withPivot('status');
    }
    
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')
            ->withPivot('status'); 
    }

    
    public function isFollowing($userId)
    {
        return $this->followings()->where('followed_id', $userId)->exists();
    }
    
    public function isFollowedBy($authUserId)
    {
        return $this->followers()->where('follower_id', $authUserId)->where('status', 'accepted')->exists();
    }

    public function acceptedFollowers()
    {
        return $this->followers()->wherePivot('status', 'accepted');
    }

    public function acceptedFollowings()
    {
        return $this->followings()->wherePivot('status', 'accepted');
    }

    public function canBeViewedBy($viewerId)
    {
        if ($this->id === $viewerId) {
            return true;
        }
        if (!$this->is_private) {
            return true;
        }
        return $this->followers()
            ->where('follower_id', $viewerId)
            ->where('status', 'accepted')
            ->exists();
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
