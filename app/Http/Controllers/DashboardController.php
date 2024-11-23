<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}