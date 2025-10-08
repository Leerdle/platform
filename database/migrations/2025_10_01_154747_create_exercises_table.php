<?php

use App\Enums\ExerciseLanguageCode;
use App\Enums\ExerciseSubject;
use App\Enums\ExerciseType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->text('description');
            $table->enum('language_code', array_column(ExerciseLanguageCode::cases(), 'value'));
            $table->enum('subject', array_column(ExerciseSubject::cases(), 'value'));
            $table->enum('type', array_column(ExerciseType::cases(), 'value'));
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['date', 'language_code', 'subject', 'type']);
        });
    }
};
