<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Reward;
use Prooph\EventSourcing\AggregateChanged;

class RewardWasAdded extends AggregateChanged
{
    public function newReward(): Reward
    {
        return $this->payload['new_reward'];
    }
}