<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = Coordinator::withCount('events')->latest()->paginate(10);
        return view('coordinators.index', compact('coordinators'));
    }

    public function create()
    {
        return view('coordinators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'title' => 'required|max:255'
        ]);

        Coordinator::create($validated);

        return redirect()->route('coordinators.index')
            ->with('success', 'Coordinator created successfully.');
    }

    public function edit(Coordinator $coordinator)
    {
        return view('coordinators.edit', compact('coordinator'));
    }

    public function update(Request $request, Coordinator $coordinator)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'title' => 'required|max:255'
        ]);

        $coordinator->update($validated);

        return redirect()->route('coordinators.index')
            ->with('success', 'Coordinator updated successfully.');
    }

    public function destroy(Coordinator $coordinator)
    {
        $coordinator->delete();

        return redirect()->route('coordinators.index')
            ->with('success', 'Coordinator deleted successfully.');
    }
}
