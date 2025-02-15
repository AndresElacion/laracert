<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Coordinator;
use App\Mail\NewsletterMail;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\EventCoordinator;
use App\Models\Event_coordinator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateTemplateCategory;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $now = Carbon::now();

        $query = Event::query()
            ->withCount('registrations') // Add this line to count registrations
            ->orderBy('event_date', 'desc');

        $announcement = Announcement::orderBy('created_at', 'desc')->get();

        switch ($filter) {
            case 'available':
                $query->where('end_date', '>=', $now);
                break;
            case 'past':
                $query->where('end_date', '<', $now);
                break;
        }

        $events = $query->paginate(9);

        return view('events.index', compact('events', 'filter'));
    }


    public function createAnnouncement()
    {
        $certificateTemplateCategories = CertificateTemplateCategory::all();
        return view('events.create-announcement', compact('certificateTemplateCategories'));
    }

    public function show(Event $event)
    {
        $availableEvents = Event::where('end_date', '>=', Carbon::now())->paginate(6);
        $event->load('certificateTemplateCategory')
        ->with(['eventCoordinators' => function($query){
                        $query->with(['coordinators']);
                    }]); // Ensure category is loaded
        return view('events.show', compact('event', 'availableEvents'));
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
            'end_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'certificate_template_category_id' => 'nullable|exists:certificate_template_categories,id',
            'coordinator_id' => 'required|array|max:5',
            'coordinator_id.*' => 'required|exists:coordinators,id',
            'type' => 'nullable|in:event,announcement',
        ]);

        // Check if a file has been uploaded
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the image in the 'public/certificates' directory
            $path = $request->file('image')->store('event', 'public');
            $validated['image'] = $path;
        }

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

        // This will send email for new created event
        $content = $validated['name']; // This will get the event name

        $emails = User::orderBy('email')->get();

        foreach ($emails as $user) {
            Mail::to($user->email)->send(new NewsletterMail($content));
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
            'end_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'certificate_template_category_id' => 'nullable|exists:certificate_template_categories,id',
            'coordinator_id' => 'array|max:5',
            'coordinator_id.*' => 'required|exists:coordinators,id'
        ]);

        if ($request->hasFile('image')) {
            // Delete old event image if exists
            if ($event->image) {
                Storage::delete($event->image);
            }

            // Store new event image
            $path = $request->file('image')->store('event', 'public');
            $validated['image'] = $path;
        }

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