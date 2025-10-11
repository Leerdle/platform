<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class GapAttackController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $exercises = Exercise::query()
            ->whereDate('date', Carbon::today()->toDateString())
            ->where('type', 1)
            ->get();

        return Inertia::render('Exercises/GapAttack/Index', [
            'exercises' => $exercises,
        ]);
    }

    /**
     * @return Response
     */
    public function show(): Response
    {
        $exercise = Exercise::query()
            ->with('questions')
            ->whereDate('date', Carbon::today()->toDateString())
            ->where('type', 1)
            ->first();

        return Inertia::render('Exercises/GapAttack/Show', [
            'exercise' => $exercise,
        ]);
    }
}
