<?php

namespace App\Console\Commands;

use App\Jobs\CheckServiceScoreJob;
use App\Models\Service\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class CheckServiceScoresCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockchain:update-score-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call Api And Update Score Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $services = Service::where('providersCount', '>', 0)
            ->get();
        foreach ($services as $service) {
            CheckServiceScoreJob::dispatch($service);
        }
    }
}
