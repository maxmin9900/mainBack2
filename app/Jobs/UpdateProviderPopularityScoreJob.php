<?php

namespace App\Jobs;

use App\Models\Service\ServiceProvider;
use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateProviderPopularityScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data, $serviceId;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $serviceId)
    {
        $this->data = $data;
        $this->serviceId = $serviceId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::findByWalletId($this->data['provider']);
            if ($user && $user->level == 2) {
                Log::info("USER IS OK");
                $service = ServiceProvider::where('user_id', $user->id)
                    ->where('service_id', $this->serviceId)
                    ->first();
                if ($service) {
                    Log::info("SERVICE IS OK " . $service->id);
                    Log::info($service);
                    $service->update([
                        'popularScore' => $this->data['inCount']
                    ]);
                    $user->updatePopularScore();
                } else {
                    Log::info("Service Not Found For U:{$user->id} , S:{$this->serviceId}");
                }
            } else {
                Log::info("USER NOT FOUND " . $this->data['provider']);
            }
        } catch (\Exception $exception) {
            Log::info("ERROR IN Popularity Job {$this->data['provider']} : " . $exception->getMessage());
        }
    }
}
