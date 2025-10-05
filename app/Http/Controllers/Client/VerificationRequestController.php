<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VerificationRequest;
use App\Services\SumsubService;
use Illuminate\Support\Facades\Auth;

class VerificationRequestController extends Controller
{
    private $sumsub;

    public function __construct(SumsubService $sumsub)
    {
        $this->sumsub = $sumsub;
    }

    public function submitDocuments()
    {
        $user = Auth::user();
        $externalUserId = 'user_' . $user->id;
        $levelName = config('services.sumsub.level_name');

        // 1. Create or fetch applicant in Sumsub
        $applicant = $this->sumsub->createApplicant($externalUserId, $levelName);
        $applicantId = isset($applicant['list']['items'][0]['id']) ? $applicant['list']['items'][0]['id'] : $applicant['id'];
        // return $applicantId;
        
        $status = $this->sumsub->getApplicantStatus($applicantId);

        if (!empty($status['reviewStatus']) && in_array($status['reviewStatus'], ['completed', 'pending', 'queued'])) {
            return redirect()->route('client.kyc')->with('success', 'Your KYB is already submitted');
        }
        
        // 2. Generate SDK Access Token
        $tokenData = $this->sumsub->getAccessToken($externalUserId, $levelName);
        $accessToken = $tokenData['token'] ?? null;

        // 3. Store verification record
        $verification = VerificationRequest::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'kyb'],
            [
                'sumsub_applicant_id' => $applicantId,
                'status'              => 'pending',
                'submitted_at'        => now(),
            ]
        );

        // 4. Return upload page
        return view('client.kyb.upload_documents')
            ->with(compact('accessToken', 'externalUserId'));
    }


    public function getAccessToken()
    {
        $user = Auth::user();

        // Ensure a verification request exists
        $verification = VerificationRequest::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'kyc'],
            ['status' => 'pending']
        );

        // Create applicant first (if needed)
        $applicant = $this->sumsub->createApplicant((string) $user->id);

        // Now get access token
        $tokenData = $this->sumsub->createAccessToken((string) $user->id);
        return $tokenData;
        return response()->json([
            'accessToken' => $tokenData['token'] ?? null,
            'applicantId' => $applicant['id'] ?? null,
        ]);
    }
}
