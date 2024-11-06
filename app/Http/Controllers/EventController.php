<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Get all upcoming and ongoing events
        $events = Event::where('event_date', '>=', now())
            ->orWhereHas('registrations', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('event_date')
            ->paginate(9); // 9 items for 3x3 grid

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function register(Event $event)
    {
        // Check if user is already registered
        $existingRegistration = $event->registrations()
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'You are already registered for this event');
        }

        // Create new registration
        $event->registrations()->create([
            'user_id' => Auth::id(),
            'status' => 'registered'
        ]);

        return back()->with('success', 'Successfully registered for the event');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:today',
            'certificate_template' => 'nullable|file|mimes:pdf'
        ]);

        if ($request->hasFile('certificate_template')) {
            $path = $request->file('certificate_template')->store('certificates');
            $validated['certificate_template'] = $path;
        }

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully');
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'certificate_template' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB max
        ]);

        if ($request->hasFile('certificate_template')) {
            // Delete old template if exists
            if ($event->certificate_template) {
                Storage::delete($event->certificate_template);
            }
            
            // Store the new image
            $path = $request->file('certificate_template')->store('certificates', 'public');
            $validated['certificate_template'] = $path;
        }

        $event->update($validated);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event updated successfully');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function updateTemplate(Request $request, Event $event)
    {
        $request->validate([
            'certificate_template' => 'required|file|mimes:pdf'
        ]);

        if ($event->certificate_template) {
            Storage::delete($event->certificate_template);
        }
        
        $path = $request->file('certificate_template')->store('certificates');
        $event->update(['certificate_template' => $path]);

        return back()->with('success', 'Certificate template updated successfully');
    }

    public function downloadTemplate(Event $event)
    {
        if (!$event->certificate_template || !Storage::exists($event->certificate_template)) {
            return back()->with('error', 'Template not found');
        }

        return Storage::download($event->certificate_template);
    }
}