<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CheckServiceScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $service;

    /**
     * Create a new job instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $baseApi ="http://127.0.0.1:8000/api";
        // Log::info($baseApi);
        //these two following lines must be uncommented :
        // Log::info("Service " . $this->service->id);
        // $baseApi = env("BLOCKCHAIN_SCORE_BASE_API", null);
       $this->callGetAllProviderPopularity($baseApi);
       $this->callGetAllProviderScore($baseApi);
    }

    private function callGetAllProviderScore($baseApi)
    {
        $response = Http::get("$baseApi/getAllProviderScore?servID=" . $this->service->id);
        $result = $response->json();

        if (array_key_exists("scores", $result)) {
            foreach ($result['scores'] as $provider) {
                if (
                    array_key_exists("scTotal", $provider) &&
                    array_key_exists("scCount", $provider) &&
                    array_key_exists("provider", $provider)
                ) {
                    UpdateProviderTrustedScoreJob::dispatch($provider, $this->service->id);
                }
            }
        }

    }

    private function callGetAllProviderPopularity($baseApi)
    {
        // Log::info("reza Log");
        // Log::info("$192.168.1.10:8000/api/getAllProviderScore?servID=");
        // return;

        $response = Http::get("$baseApi/getAllProviderPopularity?servID=" . $this->service->id);
        $result = $response->json();

        if (array_key_exists("popularity", $result)) {
            foreach ($result["popularity"] as $provider) {
                if (
                    array_key_exists("inCount", $provider) &&
                    array_key_exists("provider", $provider)
                ) {
                    UpdateProviderPopularityScoreJob::dispatch($provider, $this->service->id);
                }
            }
        }

    }
}
