<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $exercise_id
 * @property-read int $order
 * @property-read string $text
 * @property-read string $answer
 * @property-read string $metadata
 * @property-read DateTime $created_at
 * @property-read DateTime $updated_at
 */
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata' => 'array'
    ];

    /**
     * @return BelongsTo<Exercise, $this>
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }
}
