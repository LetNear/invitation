<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $fillable = [
        'name',
        'date',
        'location',
        'description',
        'organizer',
        'contact_email',
        'status', // e.g., upcoming, past
        'type', // e.g., public, private
        'image', // URL or path to an image
    ];

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'invites')
            ->withPivot('status', 'rsvp_count', 'code')
            ->withTimestamps();
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

   
}
