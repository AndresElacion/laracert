<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Event::query();

        // Check if there's a search query
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Order by most recent events
        $query->orderByDesc('event_date');

        // Paginate the results with query parameters preserved
        $events = $query->paginate(9)
            ->appends($request->query());

        return view('events.index', compact('events'));
    }
}
