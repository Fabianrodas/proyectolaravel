<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['user1_id', 'user2_id'];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function otherUser($authId)
    {
        if ($this->user1_id == $authId) {
            return $this->relationLoaded('user2') ? $this->user2 : User::find($this->user2_id);
        } else {
            return $this->relationLoaded('user1') ? $this->user1 : User::find($this->user1_id);
        }
    }
}
