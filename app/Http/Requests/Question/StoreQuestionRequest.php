<?php

namespace App\Http\Requests\Question;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'exercise_id' => ['required', 'integer'],
            'text' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'array'],
            'answer.*' => ['string', 'max:255'],
            'metadata' => ['nullable', 'array'],
            'metadata.infinitive' => ['nullable', 'string', 'max:255'],
        ];
    }
}
