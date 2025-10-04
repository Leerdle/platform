<?php

namespace App\Models;

use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use Database\Factories\ExerciseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read Carbon $date
 * @property-read string $title
 * @property-read string $description
 * @property-read ExerciseLanguageCode $language_code
 * @property-read ExerciseSubject $subject
 * @property-read ExerciseType $type
 * @property-read array $metadata
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Exercise extends Model
{
    /** @use HasFactory<ExerciseFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'language_code' => ExerciseLanguageCode::class,
            'subject' => ExerciseSubject::class,
            'type' => ExerciseType::class,
            'metadata' => 'array',
        ];
    }

    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
