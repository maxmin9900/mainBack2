<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// COMMANDS
use \App\Console\Commands\CheckServiceScoresCommand;

Schedule::command('blockchain:update-score-service')->everyMinute();
