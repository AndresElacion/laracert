<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use App\Models\EventCoordinator;
use App\Models\Event_coordinator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateTemplateCategory;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index()
    {
        // Get all upcoming and ongoing events
        $events = Event::where('event_date', '>=', now())
            ->orWhereHas('registrations', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('certificateTemplateCategory') // Eager load categories
            ->with(['eventCoordinators' => function($query){
                        $query->with(['coordinators']);
                    }])
            ->withCount('registrations')
            ->orderBy('event_date')
            ->paginate(9); // 9 items for 3x3 grid

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('certificateTemplateCategory')
        ->with(['eventCoordinators' => function($query){
                        $query->with(['coordinators']);
                    }]); // Ensure category is loaded
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

    public function create()
    {
        $categories = CertificateTemplateCategory::orderBy('name')->get();
        $coordinators = Coordinator::orderBy('name')->get();
        return view('events.create', compact(
            'categories',
            'coordinators'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after:today',
            'certificate_template_category_id' => 'nullable|exists:certificate_template_categories,id',
            'coordinator_id' => 'required|array|max:5',
            'coordinator_id.*' => 'required|exists:coordinators,id'
        ]);

        if ($request->hasFile('certificate_template')) {
            $path = $request->file('certificate_template')->store('certificates', 'public');
            $validated['certificate_template'] = $path;
        }

        $coordinators = $validated['coordinator_id'];

        unset($validated['coordinator_id']);

        $coordinators = is_array($coordinators) ? $coordinators : (array) $coordinators;

       // Create the event and retrieve the ID
        $event = Event::create($validated);

        foreach ($coordinators as $coordinator_id) {
            EventCoordinator::create([
                'event_id' => $event->id, // Use $event->id instead of $id directly
                'coordinator_id' => $coordinator_id,
            ]);
        }

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully');
    }

    public function edit(Event $event)
    {
        $categories = CertificateTemplateCategory::orderBy('name')->get();
        $coordinators = Coordinator::orderBy('name')->get();
        return view('events.edit', compact('event', 'categories', 'coordinators'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'certificate_template_category_id' => 'nullable|exists:certificate_template_categories,id',
            'coordinator_id' => 'array|max:5',
            'coordinator_id.*' => 'required|exists:coordinators,id'
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

        $coordinators = $validated['coordinator_id'] ?? [];
        unset($validated['coordinator_id']);

        $event->update($validated);

        $event->coordinators()->sync($coordinators);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Event updated successfully');
    }

    public function updateTemplate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'certificate_template' => 'required|file|mimes:jpg,jpeg,png|max:5120', // 5MB max
            'certificate_template_category_id' => 'nullable|exists:certificate_template_categories,id',
        ]);

        if ($event->certificate_template) {
            Storage::delete($event->certificate_template);
        }
        
        $path = $request->file('certificate_template')->store('certificates', 'public');
        $event->update([
            'certificate_template' => $path,
            'certificate_template_category_id' => $request->certificate_template_category_id,
        ]);

        return back()->with('success', 'Certificate template updated successfully');
    }

    public function downloadTemplate(Event $event)
    {
        if (!$event->certificate_template || !Storage::exists($event->certificate_template)) {
            return back()->with('error', 'Template not found');
        }

        return Storage::download($event->certificate_template);
    }

    public function destroy(Event $event)
    {
        if ($event->certificate_template) {
            Storage::delete($event->certificate_template);
        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully');
    }
}