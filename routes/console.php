<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('create:exercises')->dailyAt('06:00');
