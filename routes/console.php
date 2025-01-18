<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:clean')->dailyAt('3:10')->timezone('Spain/Madrid');
Schedule::command('backup:run --only-db')->dailyAt('3:20')->timezone('Spain/Madrid');
Schedule::command('backup:run')->sundays()->at('3:20')->timezone('Spain/Madrid');
