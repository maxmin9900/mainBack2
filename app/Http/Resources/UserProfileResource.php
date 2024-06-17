<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'avatar' => $this->user->getAvatar(),
            'level' => $this->user->getLevel(),
            'walletId' => $this->user->walletId,
            'trustedScore' => $this->user->trustedScore,
            'popularScore' => $this->user->popularScore,
            'serviceCount' => $this->user->serviceCount,
        ];
    }
}
