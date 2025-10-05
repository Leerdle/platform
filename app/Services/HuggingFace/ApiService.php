<?php

declare(strict_types=1);

namespace App\Services\HuggingFace;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final readonly class ApiService
{
    /** @var string $apiKey */
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config("services.hugging_face.inference_api.key");
    }

    /**
     * @param array<mixed> $body
     * @return PromiseInterface|Response
     * @throws ConnectionException
     */
    public function apiCall(array $body)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://router.huggingface.co/v1/chat/completions', $body);
    }
}
