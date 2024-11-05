<?php

namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        
        $certificateRequests = CertificateRequest::with(['eventRegistration.event'])
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        return view('dashboard', compact('certificateRequests'));
    }

    public function approve($id)
    {
        $certificateRequest = CertificateRequest::findOrFail($id);
        $certificateRequest->update(['status' => 'approved']);
        
        return back()->with('success', 'Certificate request approved successfully');
    }

    public function deny(Request $request, $id)
    {
        $request->validate([
            'denial_reason' => 'required|string|max:255'
        ]);

        $certificateRequest = CertificateRequest::findOrFail($id);
        $certificateRequest->update([
            'status' => 'denied',
            'denial_reason' => $request->denial_reason
        ]);
        
        return back()->with('success', 'Certificate request denied successfully');
    }
}