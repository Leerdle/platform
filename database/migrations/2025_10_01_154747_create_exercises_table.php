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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->string('language_code');
            $table->string('subject');
            $table->string('type');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['date', 'language_code', 'subject', 'type']);
        });
    }
};
