<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('users.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', 'unique:users,id_number'],
            'section' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'string'],
            'year' => ['required', 'string', 'max:4'],
            'student_id_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        if ($request->hasFile('student_id_image')) {
            $studentIdImagePath = $request->file('student_id_image')->store('student_id_images', 'public');
        }

        User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'id_number' => $validated['id_number'],
            'section' => $validated['section'],
            'department_id' => $validated['department_id'],
            'year' => $validated['year'],
            'student_id_image' => $studentIdImagePath ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', 'unique:users,id_number,' . $user->id],
            'section' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'string'],
            'year' => ['required', 'string', 'max:4'],
            'student_id_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', Rules\Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        if ($request->hasFile('student_id_image')) {
            // Delete old image if exists
            if ($user->student_id_image) {
                Storage::disk('public')->delete($user->student_id_image);
            }
            $studentIdImagePath = $request->file('student_id_image')->store('student_id_images', 'public');
            $user->student_id_image = $studentIdImagePath;
        }

        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'];
        $user->last_name = $validated['last_name'];
        $user->id_number = $validated['id_number'];
        $user->section = $validated['section'];
        $user->department_id = $validated['department_id'];
        $user->year = $validated['year'];
        $user->email = $validated['email'];
        $user->is_admin = $request->boolean('is_admin', false);

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->student_id_image) {
            Storage::disk('public')->delete($user->student_id_image);
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}