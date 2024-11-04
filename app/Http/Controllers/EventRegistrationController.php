<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventRegistration;

class EventRegistrationController extends Controller
{
    public function index(Event $event)
    {
        $registrations = $event->registrations()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('events.registrations.index', compact('event', 'registrations'));
    }

    public function updateStatus(Request $request, Event $event, EventRegistration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:registered,attended'
        ]);

        $registration->update($validated);

        return back()->with('success', 'Attendance status updated successfully');
    }
}
