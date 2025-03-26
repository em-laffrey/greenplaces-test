<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use JsonException;
use RuntimeException;

class ApiService
{
    public function __construct(
        private string $baseUrl,
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get(string $endpoint, array $params = []): array
    {
        try {
            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $response = Http::timeout(30)
                ->withHeaders($headers)
                ->get($url, $params);

            if (!$response->successful()) {
                throw new RequestException($response);
            }

            return $response->json();
        } catch (ConnectionException $e) {
            throw new RuntimeException('Failed to connect to API: ' . $e->getMessage());
        } catch (RequestException $e) {
            throw new RuntimeException(
                "API request failed: {$e->response->status()} {$e->response->body()}"
            );
        } catch (JsonException $e) {
            throw new RuntimeException('Invalid JSON response: ' . $e->getMessage());
        }
    }
}
