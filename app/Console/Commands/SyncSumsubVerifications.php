<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VerificationRequest;
use App\Models\KycDocument;
use App\Models\KybDocument;
use App\Services\SumsubService;
use Illuminate\Support\Facades\DB;

class SyncSumsubVerifications extends Command
{
    protected $signature = 'sumsub:sync';
    protected $description = 'Sync verification requests and documents from Sumsub';

    protected $sumsub;

    public function __construct(SumsubService $sumsub)
    {
        parent::__construct();
        $this->sumsub = $sumsub;
    }

    public function handle()
    {
        $this->info('Starting Sumsub sync...');

        $verifications = VerificationRequest::whereIn('status', ['pending', 'in_progress'])->get();

        if ($verifications->isEmpty()) {
            $this->info('No verifications to sync.');
            return;
        }

        foreach ($verifications as $verification) {
            $this->info("Syncing applicant: {$verification->sumsub_applicant_id}");

            try {
                // 🔥 Fetch full applicant data
                $details = $this->sumsub->getApplicantByExternalUserId("user_{$verification->user_id}");
                $applicant = $details['list']['items'][0] ?? null;

                if (!$applicant || empty($applicant['inspectionId'])) {
                    $this->warn("No inspection found for applicant {$verification->id}");
                    continue;
                }

                $this->info("Inspection ID: " . $applicant['inspectionId']);


                if (!$applicant) {
                    $this->warn("No applicant found for verification {$verification->id}");
                    continue;
                }

                DB::transaction(function () use ($verification, $applicant) {
                    $this->syncVerification($verification, $applicant);
                    $this->syncDocuments($verification, $applicant);
                });

                $this->info("✅ Synced applicant {$verification->sumsub_applicant_id}");

            } catch (\Throwable $e) {
                $this->error("❌ Failed for applicant {$verification->sumsub_applicant_id}: " . $e->getMessage());
            }
        }

        $this->info('✅ Sumsub sync completed.');
    }

    /**
     * Sync verification record
     */
    protected function syncVerification($verification, $applicant)
    {
        $review = $applicant['review'] ?? [];
        $reviewStatus = strtolower($review['reviewStatus'] ?? 'pending');
        $reviewAnswer = strtolower($review['reviewResult']['reviewAnswer'] ?? null);

        // 🔥 Map reviewStatus + reviewAnswer to DB status
        $statusMap = [
            'pending'    => 'pending',
            'init'       => 'pending',
            'queued'     => 'in_progress',
            'inprogress' => 'in_progress',
            'completed'  => $reviewAnswer === 'green' ? 'approved' : 'rejected',
        ];

        $status = $statusMap[$reviewStatus] ?? 'pending';
        $this->info("✅ Synced review {$status}");
        $verification->update([
            'sumsub_applicant_id' => $applicant['inspectionId'],
            'status'      => $status,
            'reviewed_at' => in_array($status, ['approved', 'rejected']) ? now() : null,
            'metadata'    => $applicant,
        ]);
    }

    /**
     * Sync documents from applicant's idDocs and store images
     */
    protected function syncDocuments($verification, $applicant)
    {
        $inspectionId = $applicant['inspectionId'] ?? null;
        $documents = [];

        if ($inspectionId) {
            try {
                $documents = $this->sumsub->downloadDocumentImages($inspectionId);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                if ($e->getCode() === 404) {
                    $this->warn("No documents found yet for inspection $inspectionId");
                    $documents = [];
                } else {
                    throw $e;
                }
            }
        }

        $docModel = $verification->type === 'kyc' ? KycDocument::class : KybDocument::class;

        $reviewAnswerMap = [
                                'green' => 'approved',
                                'red'   => 'rejected',
                                'pending' => 'pending', // optional, in case Sumsub returns 'pending'
                            ];

        foreach ($documents as $doc) {
            
            $status = $reviewAnswerMap[$doc['status']] ?? 'pending';

            $docTypeMap = [
                'id_card'        => 'id_card',
                'passport'       => 'passport',
                'driver_license' => 'driver_license',
                'selfie'         => 'selfie',
            ];

            $docModel::updateOrCreate(
                [
                    'verification_id' => $verification->id,
                    'sumsub_doc_id'   => $doc['id'],
                ],
                [
                    'type'      => $docTypeMap[$doc['type']] ?? $doc['type'],
                    'status'    => $status,
                    'file_path' => $doc['file_path'],
                    'metadata'  => $doc['metadata'],
                ]
            );
        }
    }


}
