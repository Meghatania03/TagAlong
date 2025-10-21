<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','title','description','location','starts_at'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function interestedUsers()
    {
        return $this->belongsToMany(Users::class, 'event_user', 'event_id', 'user_id')->withTimestamps();
    }
}
