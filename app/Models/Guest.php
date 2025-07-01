<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Guest extends Model
{
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status', // e.g., pending, accepted
        'rsvp_limit',
        'affiliation', // e.g., Ninong, Ninang, Kuya, Ate, Tito, Tita
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

        public function scopeWithoutInvites(Builder $query): Builder
    {
        return $query->whereDoesntHave('invites');
    }
}
