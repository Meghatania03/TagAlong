<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'phone',
        'bio',
        'profile_picture',
        'location',
        'interests',
        'social_links',
    ];
    /** @use HasFactory<\Database\Factories\UsersFactory> */
    use HasFactory;
}
