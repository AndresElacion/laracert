<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'event_date' => 'datetime'
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function hasUserRegistered()
    {
        return $this->registrations()
            ->where('user_id', Auth::id())
            ->exists();
    }

    public function userCanRequestCertificate()
    {
        $registration = $this->registrations()
            ->where('user_id', Auth::id())
            ->where('status', 'attended')
            ->first();

        if (!$registration) {
            return false;
        }

        return !CertificateRequest::where('event_registration_id', $registration->id)->exists();
    }

    public function getUserRegistrationStatus()
    {
        $registration = $this->registrations()
            ->where('user_id', Auth::id())
            ->first();
        
        return $registration ? $registration->status : null;
    }

    public function hasUserRequestedCertificate()
    {
        return $this->registrations()
            ->where('user_id', Auth::id())
            ->whereHas('certificateRequest')
            ->exists();
    }

    public function getUserCertificateStatus()
    {
        $registration = $this->registrations()
            ->where('user_id', Auth::id())
            ->whereHas('certificateRequest')
            ->with('certificateRequest')
            ->first();

        return $registration ? $registration->certificateRequest->status : null;
    }

    public function getUserCertificate()
    {
        $registration = $this->registrations()
            ->where('user_id', Auth::id())
            ->whereHas('certificateRequest')
            ->with('certificateRequest')
            ->first();

        return $registration ? $registration->certificateRequest : null;
    }

    public function certificateTemplateCategory()
    {
        return $this->belongsTo(CertificateTemplateCategory::class);
    }
}