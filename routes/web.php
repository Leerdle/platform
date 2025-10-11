<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GapAttackController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

 Route::get('/', [HomeController::class, 'index'])->name('home');

// To change to commented one
// Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercise.index');
Route::redirect('/exercises', '/exercises/gap-attack')->name('exercise.index');

// To change to commented one
// Route::get('/exercises/gap-attack', [GapAttackController::class, 'index'])->name('gap-attack.index');
Route::get('/exercises/gap-attack', [GapAttackController::class, 'show'])->name('gap-attack.show');

// To change to commented one
// Route::get('/exercises/gap-attack/{id}', [GapAttackController::class, 'show'])->name('gap-attack.showOne');
Route::redirect('/exercises/gap-attack/{id}', '/exercises/gap-attack')->name('gap-attack.showOne');
