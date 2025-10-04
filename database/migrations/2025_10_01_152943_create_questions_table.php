<?php

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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises');
            $table->string('text');
            $table->string('answer');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
};
