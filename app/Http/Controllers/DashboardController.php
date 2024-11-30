<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $user = Auth::user();

        // Get counts for all statuses
        $statusCounts = CertificateRequest::query()
            ->when(!$user->is_admin, function ($query) use ($user) {
                $query->whereHas('eventRegistration', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Get filtered certificate requests
        $certificateRequests = CertificateRequest::with(['eventRegistration.event'])
            ->when(!$user->is_admin, function ($query) use ($user) {
                $query->whereHas('eventRegistration', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        // Set default counts for all statuses
        $counts = [
            'pending' => $statusCounts['pending'] ?? 0,
            'approved' => $statusCounts['approved'] ?? 0,
            'denied' => $statusCounts['denied'] ?? 0,
        ];

        return view('dashboard', compact('certificateRequests', 'counts'));
    }

    public function approve($id)
    {
        $certificateRequest = CertificateRequest::whereHas('eventRegistration', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $certificateRequest->update(['status' => 'approved']);
        
        return back()->with('success', 'Certificate request approved successfully');
    }

    public function deny(Request $request, $id)
    {
        $request->validate([
            'denial_reason' => 'required|string|max:255'
        ]);

        $certificateRequest = CertificateRequest::whereHas('eventRegistration', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);
        
        $certificateRequest->update([
            'status' => 'denied',
            'denial_reason' => $request->denial_reason
        ]);
        
        return back()->with('success', 'Certificate request denied successfully');
    }

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
            }
        } elseif ($validated['action'] === 'deny') {
            foreach ($certificates as $certificate) {
                $certificate->update([
                    'status' => 'denied',
                    'denial_reason' => $request->denial_reason
                ]);
            }
        } elseif ($validated['action'] === 'download') {
            return $this->bulkDownload($certificates);
        }

        return back()->with('success', 'Bulk action completed successfully');
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
}