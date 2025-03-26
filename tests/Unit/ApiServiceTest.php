<?php

namespace Tests\Unit;

use App\Services\ApiService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    private string $baseUrl = 'https://api.test';
    private ApiService $apiService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiService = new ApiService($this->baseUrl);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_makes_get_request_with_correct_parameters()
    {
        Http::fake([
            "*" => Http::response(['data' => 'test'], 200)
        ]);

        $params = ['param1' => 'value1'];
        $this->apiService->get('test-endpoint', $params);

        Http::assertSent(function (Request $request) use ($params) {
            return str_starts_with($request->url(), $this->baseUrl) &&
                   str_contains($request->url(), 'test-endpoint') &&
                   $request->method() === 'GET' &&
                   $request['param1'] === 'value1';
        });
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_exception_on_connection_error()
    {
        Http::fake([
            "*" => Http::response('Connection failed', 500)
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('API request failed');

        $this->apiService->get('test-endpoint');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_exception_on_api_error()
    {
        Http::fake([
            "*" => Http::response(['error' => 'Bad request'], 400)
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('API request failed');

        $this->apiService->get('test-endpoint');
    }
}
