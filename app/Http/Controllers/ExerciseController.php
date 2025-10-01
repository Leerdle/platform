<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExerciseController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $exercise = Exercise::query()
            ->whereDate('date', Carbon::today()->toDateString())
            ->first()
            ->load('questions');

        return Inertia::render('Home', [
            'exercise' => $exercise,
        ]);
    }
}
