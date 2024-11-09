<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $guarded = [];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_coordinators')
                    ->withPivot('event_id', 'coordinator_id')
                    ->withTimestamps();
    }
}
