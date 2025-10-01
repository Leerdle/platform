<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read int $order
 * @property-read string $text
 * @property-read string $answer
 * @property-read string $metadata
 */
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;
}
