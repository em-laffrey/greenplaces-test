<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ApiService
{
    public function __construct(
        private string $baseUrl,
        private ?string $apiKey = null
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get(string $endpoint, array $params = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->apiKey) {
            $headers['Authorization'] = 'Bearer ' . $this->apiKey;
        }

        $response = Http::withHeaders($headers)->get($url, $params);

        if (!$response->successful()) {
            throw new Exception("API request failed: {$response->status()} {$response->body()}");
        }

        return $response->json();
    }
}
