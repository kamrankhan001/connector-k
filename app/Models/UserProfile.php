<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'university',
        'area',
        'city',
        'country',
        'hobbies',
        'occupation',
        'age',
        'education',
        'language',
        'skills',
        'image',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
