<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Description;
use App\Domain\Quest\Reward;
use Prooph\EventSourcing\AggregateChanged;

class RewardsWereReceived extends AggregateChanged
{
    /**
     * @return Reward[]
     */
    public function receiveRewards(): array
    {
        return $this->payload['received_rewards'];
    }
}