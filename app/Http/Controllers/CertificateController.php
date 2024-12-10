<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Event;
use App\Mail\ApprovedMail;
use App\Mail\DeniedMail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'certificates' => 'required|array',
            'action' => 'required|in:approve,deny,download'
        ]);

        $certificates = CertificateRequest::whereIn('id', $validated['certificates'])->get();

        if ($validated['action'] === 'approve') {
            foreach ($certificates as $certificate) {
                $certificate->update(['status' => 'approved']);

                // Send email notification
                $content = "Your certificate request has been approved.";
                Mail::to($certificate->eventRegistration->user->email)->send(new ApprovedMail($content));
            }
        } elseif ($validated['action'] === 'deny') {
            foreach ($certificates as $certificate) {
                $certificate->update([
                    'status' => 'denied',
                    'denial_reason' => $request->denial_reason
                ]);

                // Send email notification
                $content = "Your certificate request has been denied.";
                Mail::to($certificate->eventRegistration->user->email)->send(new DeniedMail($content));
            }
        } elseif ($validated['action'] === 'download') {
            return $this->bulkDownload($certificates);
        }

        return back()->with('success', 'Bulk action completed successfully');
    }

    public function download($id)
    {
        $certificate = CertificateRequest::with([
            'eventRegistration' => function($query){
                $query->with(['event' => function($query){
                    $query->with(['eventCoordinators' => function($query){
                        $query->with(['coordinators']);
                    }]);
                }]);
            }
        ])->findOrFail($id);

        // dd($certificate->eventRegistration->event->coordinators->count());
        // First check if certificate is approved
        if ($certificate->status !== 'approved') {
            return back()->with('error', 'Certificate must be approved before downloading');
        }

        // Check if user is admin
        if (!Auth::user()->is_admin === true) {
            // Only apply download restriction for non-admin users
            if ($certificate->downloaded_at) {
                return back()->with('error', 'Certificate has already been downloaded.');
            }
            
            // Update the downloaded_at timestamp for non-admin users
            $certificate->update(['downloaded_at' => now()]);
        }

        // Generate PDF
        $pdf = $this->generateCertificate($certificate);

        return $pdf->download('certificate_' . $certificate->id . '.pdf');
    }

    private function generateCertificate(CertificateRequest $request)
    {
        // Create PDF instance using the facade
        $pdf = Pdf::loadView('certificates.template', [
            'user' => $request->eventRegistration->user,
            'event' => $request->eventRegistration->event,
            'certificate' => $request
        ]);

        // Configure PDF settings
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOptions([
            'dpi' => 300,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path('storage'),
            'enable_php' => true,
            'enable_remote' => true
        ]);

        return $pdf;
    }

    private function bulkDownload($certificates)
    {
        $zip = new ZipArchive();
        $fileName = 'certificates_' . time() . '.zip';
        $zipPath = storage_path('app/public/' . $fileName);
        
        // Ensure the temp directory exists
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($certificates as $certificate) {
                if ($certificate->status === 'approved') {
                    $pdf = $this->generateCertificate($certificate);
                    $pdfName = 'certificate_' . $certificate->id . '.pdf';
                    $pdfPath = $tempDir . '/' . $pdfName;

                    // Save PDF to temporary storage
                    $pdf->save($pdfPath);

                    // Add to ZIP
                    $zip->addFile($pdfPath, $pdfName);
                }
            }
            $zip->close();

            // Clean up temporary PDF files
            foreach ($certificates as $certificate) {
                $pdfPath = $tempDir . '/certificate_' . $certificate->id . '.pdf';
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            }

            return response()->download($zipPath)->deleteFileAfterSend();
        }

        return back()->with('error', 'Could not create zip file');
    }

    public function userCertificates()
    {
        $certificates = CertificateRequest::query()
            ->whereHas('eventRegistration', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['eventRegistration.event'])
            ->latest()
            ->paginate(10);

        return view('certificates.my-certificates', compact('certificates'));
    }

    public function requestCertificate(Event $event)
    {
        // Check if user is registered and attended
        $registration = auth()->user()->eventRegistrations()
            ->where('event_id', $event->id)
            ->where('status', 'attended')
            ->first();

        if (!$registration) {
            return back()->with('error', 'You must attend the event to request a certificate');
        }

        // Check if certificate already requested
        $existingRequest = CertificateRequest::where('event_registration_id', $registration->id)->first();
        if ($existingRequest) {
            return back()->with('error', 'You have already requested a certificate for this event');
        }

        CertificateRequest::create([
            'event_registration_id' => $registration->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Certificate requested successfully');
    }

    public function showApprovalPage()
    {
        // Fetch all certificate requests with event and user information
        $certificates = CertificateRequest::with(['eventRegistration.user', 'eventRegistration.event'])
            ->latest()
            ->paginate(10);

        return view('admin.certificates.index', compact('certificates'));
    }

    public function preview($id)
    {
        $certificate = CertificateRequest::with([
            'eventRegistration' => function($query) {
                $query->with(['event', 'user']);
            }
        ])->findOrFail($id);

        $coordinators = CertificateRequest::with([
            'eventRegistration' => function($query){
                $query->with(['event' => function($query){
                    $query->with(['eventCoordinators' => function($query){
                        $query->with(['coordinators']);
                    }]);
                }]);
            }
        ])->findOrFail($id);

        return view('certificates.preview', compact('certificate', 'coordinators'));
    }
}
