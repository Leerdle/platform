<?php

use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ExerciseController::class, 'index'])->name('home');
