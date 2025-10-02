<?php

namespace App\Http\Requests\Exercise;

use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'language_code' => ['required', Rule::enum(ExerciseLanguageCode::class)],
            'subject' => ['required', Rule::enum(ExerciseSubject::class)],
            'type' => ['required', Rule::enum(ExerciseType::class)],
            'metadata' => ['nullable', 'array'],
            'date' => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
