<?php

namespace App\Models;

use Carbon\Traits\Date;
use Database\Factories\ExerciseFactory;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read Date $date
 * @property-read string $title
 * @property-read int $language_code
 * @property-read int $subject
 * @property-read int $type
 * @property-read string $metadata
 * @property-read DateTime $created_at
 * @property-read DateTime $updated_at
 */
class Exercise extends Model
{
    /** @use HasFactory<ExerciseFactory> */
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'date' => 'datetime',
        'metadata' => 'array'
    ];

    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
