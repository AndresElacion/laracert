<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Handle email or database logic here
        Mail::raw($request->message, function ($message) use ($request) {
            $message->to('andreielacion5@gmail.com')
                    ->subject($request->subject)
                    ->from($request->email, $request->name);
        });

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
