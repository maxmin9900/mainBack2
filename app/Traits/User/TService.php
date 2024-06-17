<?php

namespace App\Traits\User;

use App\Models\Service\ServiceProvider;

trait TService
{
    public function Services()
    {
        return $this->hasMany(ServiceProvider::class,
            'user_id');
    }

    public function updateTrustedScore()
    {
        $trustScores = $this->Services()->average("trustedScore");
        $this->update([
            'trustedScore' => $trustScores,
        ]);
    }

    public function updatePopularScore()
    {
        $popularScores = $this->Services()->average("popularScore");
        $this->update([
            'popularScore' => $popularScores,
        ]);
    }

    public function updateScores()
    {
        $trustScores = $this->Services()->average("trustedScore");
        $popularScores = $this->Services()->average("popularScore");

        $this->update([
            'trustedScore' => $trustScores,
            'popularScore' => $popularScores,
        ]);

    }
}
