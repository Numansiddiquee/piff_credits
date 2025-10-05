<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class SumsubService
{
    private const BASE_URL = 'https://api.sumsub.com';
    private $http;
    private $appToken;
    private $secretKey;

    public function __construct($appToken, $secretKey)
    {
        $this->appToken = $appToken;
        $this->secretKey = $secretKey;
        $this->http = new Client(['base_uri' => self::BASE_URL]);
    }

    /**
     * Create a new applicant in Sumsub
     */
    public function createApplicant($externalUserId, $levelName)
    {
        $body = [
            'externalUserId' => $externalUserId,
        ];

        $url = '/resources/applicants?' . http_build_query(['levelName' => $levelName]);

        $request = new Request(
            'POST',
            $url,
            ['Content-Type' => 'application/json'],
            Utils::streamFor(json_encode($body))
        );

        try {
            $response = $this->send($request);
            return $this->decode($response);
        } catch (\RuntimeException $e) {
            if (str_contains($e->getMessage(), '409')) {
                return $this->getApplicantByExternalUserId($externalUserId);
            }
            throw $e;
        }
    }

    public function getApplicantStatus(string $applicantId): array
    {
        $request = new Request(
            'GET',
            "/resources/applicants/{$applicantId}/status"
        );

        $response = $this->send($request);

        return $this->decode($response);
    }

    /**
     * Get applicant details by external user ID
     */
    public function getApplicantByExternalUserId($externalUserId)
    {
        $url = '/resources/applicants/-;externalUserId=' . urlencode($externalUserId);
        $request = new Request('GET', $url);

        $response = $this->send($request);
        return $this->decode($response);
    }

    /**
     * Get SDK access token
     */
    public function getAccessToken($externalUserId, $levelName)
    {
        $body = [
            'userId'    => $externalUserId,
            'levelName' => $levelName,
        ];

        $request = new Request(
            'POST',
            '/resources/accessTokens/sdk',
            ['Content-Type' => 'application/json'],
            Utils::streamFor(json_encode($body))
        );

        $response = $this->send($request);
        return $this->decode($response);
    }

    /**
     * Get applicant status
     */
    // public function getApplicantStatus($applicantId)
    // {
    //     $request = new Request('GET', "/resources/applicants/$applicantId/requiredIdDocsStatus");
    //     $response = $this->send($request);
    //     return $this->decode($response);
    // }

    /**
     * Download and store all document images for an applicant
     */
    public function downloadDocumentImages(string $inspectionId): array
    {
        $documents = [];

        // Step 1: Get all resources for this inspection
        $resourceListRequest = new Request(
            'GET',
            "/resources/applicants/{$inspectionId}/metadata/resources"
        );
        $resourceResponse = $this->send($resourceListRequest);

        $resources = $this->decode($resourceResponse);

        foreach ($resources['items']  as $resource) {

            $imageId = $resource['id'] ?? null;
            if (!$imageId) {
	            continue; 
	        }

            // Step 2: Download binary file
            $downloadRequest = new Request(
                'GET',
                "/resources/inspections/{$inspectionId}/resources/{$imageId}"
            );

            $ts = time();
            $signature = hash_hmac(
                'sha256',
                $ts . strtoupper($downloadRequest->getMethod()) . $downloadRequest->getUri(),
                $this->secretKey
            );

            $signedRequest = $downloadRequest
                ->withHeader('X-App-Token', $this->appToken)
                ->withHeader('X-App-Access-Sig', $signature)
                ->withHeader('X-App-Access-Ts', $ts);

            $fileResponse = $this->http->send($signedRequest);
            $fileContent = $fileResponse->getBody()->getContents();

            // Step 3: Save file in storage
            $publicDir = public_path('kyc_docs');
		    if (!file_exists($publicDir)) {
		        mkdir($publicDir, 0755, true);
		    }



            $extension = strtolower(pathinfo($resource['fileMetadata']['fileName'] ?? 'file.jpg', PATHINFO_EXTENSION) ?: 'jpg');
	        $fileName = "sumsub_{$inspectionId}_{$imageId}.{$extension}";
	        $filePath = $publicDir . DIRECTORY_SEPARATOR . $fileName;
	        
	        if (!file_exists($filePath)) {
			    file_put_contents($filePath, $fileContent);
			}

	        file_put_contents($filePath, $fileContent);

	        // Step 4: Save relative path for database
	        $documents[] = [
            'id'        => $imageId,
            'type'      => strtolower($resource['idDocDef']['idDocType'] ?? 'unknown'),
            'status'    => strtolower($resource['reviewResult']['reviewAnswer'] ?? 'pending'),
            'file_path' => 'kyc_docs/' . $fileName,
            'metadata'  => $resource,
        ];
        }

        return $documents;
    }

    /**
     * Send signed request
     */
    private function send(RequestInterface $request): ResponseInterface
    {
        $ts = time();
        $signature = hash_hmac(
            'sha256',
            $ts . strtoupper($request->getMethod()) . $request->getUri() . $request->getBody(),
            $this->secretKey
        );

        $signed = $request
            ->withHeader('X-App-Token', $this->appToken)
            ->withHeader('X-App-Access-Sig', $signature)
            ->withHeader('X-App-Access-Ts', $ts);

        try {
            $response = $this->http->send($signed);
            if (!in_array($response->getStatusCode(), [200, 201])) {
                throw new RuntimeException(
                    "Sumsub error: {$response->getStatusCode()} - {$response->getBody()}"
                );
            }
            return $response;
        } catch (\Throwable $e) {
            throw new RuntimeException("Sumsub request failed: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Decode JSON response
     */
    private function decode(ResponseInterface $response)
    {
        $json = json_decode((string) $response->getBody(), true);
        return is_array($json) ? $json : [];
    }
}
