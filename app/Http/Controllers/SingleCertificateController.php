<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SingleCertificateController extends Controller
{
    public function showUserCertificateForm($userId)
    {
        $user = User::findOrFail($userId);
        $events = Event::with([
            'certificateTemplateCategory',
            'eventCoordinators.coordinators'  // Keep plural as per model
        ])
        ->whereHas('certificateTemplateCategory')
        ->orderBy('end_date', 'desc')
        ->get();
                      
        return view('certificates.single.create', compact('user', 'events'));
    }

    public function generateSingleCertificate(Request $request, $userId)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'certificate_date' => 'required|date',
            'remarks' => 'nullable|string|max:255'
        ]);

        $user = User::findOrFail($userId);
        
        $event = Event::with([
            'certificateTemplateCategory',
            'eventCoordinators.coordinators'  // Keep plural as per model
        ])->findOrFail($request->event_id);

        if (!$event->certificateTemplateCategory) {
            return back()->with('error', 'No certificate template found for this event.');
        }

        $pdf = $this->generatePDF($user, $event, $request->certificate_date, $request->remarks);

        return $pdf->download('certificate_'.$user->id_number.'_'.$event->id.'.pdf');
    }

    public function previewSingleCertificate(Request $request, $userId)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'certificate_date' => 'required|date',
            'remarks' => 'nullable|string|max:255'
        ]);

        $user = User::findOrFail($userId);
        $event = Event::with([
            'certificateTemplateCategory',
            'eventCoordinators.coordinators'  // Keep plural as per model
        ])->findOrFail($request->event_id);
        
        if (!$event->certificateTemplateCategory) {
            return back()->with('error', 'No certificate template found for this event.');
        }

        $pdf = $this->generatePDF($user, $event, $request->certificate_date, $request->remarks);

        return $pdf->stream('certificate_preview.pdf');
    }

    private function generatePDF($user, $event, $certificateDate, $remarks)
    {
        $fullName = trim($user->first_name . ' ' . 
                    ($user->middle_name ? $user->middle_name . ' ' : '') . 
                    $user->last_name);

        // Extract coordinators using the correct relationship name
        $coordinators = $event->eventCoordinators->map(function ($eventCoordinator) {
            return $eventCoordinator->coordinators;
        })->flatten();

        if ($coordinators->isEmpty()) {
            $coordinators = collect(); // Avoid errors in the Blade template
        }

        $pdf = PDF::loadView('certificates.single.template', [
            'user' => [
                'name' => $fullName,
                'id_number' => $user->id_number,
                'year' => $user->year,
                'section' => $user->section
            ],
            'event' => $event,
            'eventType' => $event->certificateTemplateCategory->name ?? 'General Event',
            'certificateDate' => date('F d, Y', strtotime($certificateDate)),
            'remarks' => $remarks,
            'coordinators' => $coordinators
        ]);

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'dpi' => 300,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path('storage'),
            'enable_php' => true,
            'enable_remote' => true,
            'images' => true
        ]);

        return $pdf;
    }
}