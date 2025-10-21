<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','gender','age','phone','bio','profile_picture','location','interests','social_links'
    ];

    protected $hidden = ['password','remember_token'];

    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    public function interestedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_user', 'user_id', 'event_id')->withTimestamps();
    }
}
