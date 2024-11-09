<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCoordinator extends Model
{
    protected $table = 'event_coordinators';
    protected $fillable = [
        'event_id',
        'coordinator_id',
    ];

     public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relationship to Coordinator
    public function coordinators()
    {
        return $this->belongsTo(Coordinator::class);
    }
}
