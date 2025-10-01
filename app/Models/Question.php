<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
