<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    protected $guarded = [];

    public function eventRegistration()
    {
        return $this->belongsTo(EventRegistration::class);
    }
}
