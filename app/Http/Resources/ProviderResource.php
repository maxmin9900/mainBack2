<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProviderResource extends JsonResource
{
    private $user;

    /**
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'avatar' => $this->user->getAvatar(),
            'trustedScore' => $this->user->trustedScore,
            'popularScore' => $this->user->popularScore,
            'walletId' => $this->user->walletId,
            'serviceCount' => $this->user->serviceCount
        ];
    }
}
