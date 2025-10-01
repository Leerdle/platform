<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use SensitiveParameter;

final readonly class HuggingFaceApi
{
    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct(#[SensitiveParameter] string $apiKey)
    {
        $this->apiKey = config("hugging_face.inference_api.key");
    }

    /**
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function createExercise(): JsonResponse
    {
        $requestData = [
            "messages" => [
                [
                    "role" => "student",
                    "content" => "Give me 5 challenging sentences in Dutch using the imperfect tense at C1 language level. The statements should be challenging and realistic using good grammar and interesting vocabulary. Include at least 1 question. Use a mix of regular and irregular verbs. Make sure all verbs are unique in the exercise. Include both singular and plural forms. The imperfect verb in each sentence should be replaced with <mask> and the answer should be provided separately. I expect the response back in JSON format such as the following: [{'question': 'Ik <mask> naar de supermarkt.', 'answer': 'ging', 'infinitive': 'gaan'}, {'question': 'Waar <mask> jullie gisteren avond?', 'answer': 'waren', 'infinitive': 'zijn'}]"
                ]
            ],
            "model" => "Qwen/Qwen2.5-7B-Instruct:together",
            "stream" => false,
            "temperature" => 0.7,
            "seed" => rand(1, 1000000)
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://router.huggingface.co/v1/chat/completions', $requestData);

        return response()->json($response->json(), $response->status());
    }
}
