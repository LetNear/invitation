<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status', // e.g., pending, accepted
        'rsvp_limit',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'invites')
            ->withPivot('status', 'rsvp_count', 'code')
            ->withTimestamps();
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
}
