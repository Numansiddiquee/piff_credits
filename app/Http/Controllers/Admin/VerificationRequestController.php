<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VerificationRequest;

class VerificationRequestController extends Controller
{
    

    public function showDocuments($id)
    {
        $req = VerificationRequest::with(['user.roles','company','kycDocuments', 'kybDocuments'])->find($id);
        // return $req;
        $documents = $req->type === 'kyc'  ? $req->kycDocuments  : $req->kybDocuments;
        
        // $documents = [];
        return view('admin.verification_request.view', [
            'req'       => $req,
            'user'      => $req->user ?? null, // reusing template
            'documents' => $documents,
            'action'    => 'view'
        ]);
        return view('admin.verification_request.view', compact('req','documents'));
    }

    public function approve($id)
    {
        $req = VerificationRequest::findOrFail($id);
        $req->update(['status' => 'approved']);
        return response()->json(['status' => 'approved']);
    }

    public function reject($id)
    {
        $req = VerificationRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);
        return response()->json(['status' => 'rejected']);
    }

}
