<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Mail\NewsletterMail;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Mail\AnnouncementMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['user', 'event'])->latest()->paginate(10);
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $events = Event::all();
        return view('announcements.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_id' => 'required|exists:events,id'
        ]);

        $validated['user_id'] = Auth::id();

        Announcement::create($validated);

        $content = $validated['title'];

        $emails = User::orderBy('email')->get();

        foreach ($emails as $user) {
            Mail::to($user->email)->send(new AnnouncementMail($content));
        }

        return redirect()->route('events.index')
            ->with('success', 'Announcement created successfully');
    }

    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $events = Event::all();
        return view('announcements.edit', compact('announcement', 'events'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_id' => 'required|exists:events,id'
        ]);

        $announcement->update($validated);

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement updated successfully');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Announcement deleted successfully');
    }
}