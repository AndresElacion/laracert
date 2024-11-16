<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        
        $certificateRequests = CertificateRequest::with(['eventRegistration.event'])
            ->whereHas('eventRegistration', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        return view('dashboard', compact('certificateRequests'));
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