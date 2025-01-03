<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'accepted',
    ];

    // The user who sent the friend request
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // The user who received the friend request
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
