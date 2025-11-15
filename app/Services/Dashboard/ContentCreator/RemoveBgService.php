<?php

namespace App\Services\Dashboard\ContentCreator;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class RemoveBgService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.removebg.api_key');
        $this->apiUrl = config('services.removebg.api_url');
    }

    /**
     * Xóa phông nền từ file upload
     */
    public function removeBackground($imageFile)
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Key' => $this->apiKey,
            ])->attach(
                'image_file',
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post($this->apiUrl, [
                'size' => 'auto',
            ]);

            if ($response->successful()) {
                return $response->body(); // Binary image data
            }

            throw new Exception('API Error: ' . $response->json()['errors'][0]['title'] ?? 'Unknown error');
        } catch (Exception $e) {
            throw new Exception('Failed to remove background: ' . $e->getMessage());
        }
    }
}