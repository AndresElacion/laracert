<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function certificateRequest()
    {
        return $this->hasOne(CertificateRequest::class);
    }

    public function certificateTemplateCategory()
    {
        return $this->belongsTo(CertificateTemplateCategory::class);
    }
}
