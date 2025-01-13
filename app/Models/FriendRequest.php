<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FriendRequest extends Model
{
    use HasFactory;

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
