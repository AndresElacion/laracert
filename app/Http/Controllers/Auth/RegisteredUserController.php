<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departments = Department::orderBy('created_at', 'desc')->get();
        
        return view('auth.register', [
            'departments' => $departments
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255', 'unique:users,id_number'],
            'section' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'string'],
            'year' => ['required', 'string', 'max:4'],
            'student_id_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Handle the student ID image upload
        if ($request->hasFile('student_id_image')) {
            $studentIdImagePath = $request->file('student_id_image')->store('student_id_images', 'public');
        }

        User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'id_number' => $request->id_number,
            'section' => $request->section,
            'department_id' => $request->department_id,
            'year' => $request->year,
            'student_id_image' => $studentIdImagePath ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect(route('dashboard', absolute: false));
    }
}
