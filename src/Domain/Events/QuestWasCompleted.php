<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\CompletedAt;
use App\Domain\Quest\Description;
use Prooph\EventSourcing\AggregateChanged;

class QuestWasCompleted extends AggregateChanged
{
    public function isComplete(): bool
    {
        return $this->payload['is_complete'];
    }

    public function completedAt(): CompletedAt
    {
        return $this->payload['completed_at'];
    }

    public function oldStateOfIsComplete(): Description
    {
        return $this->payload['old_state_is_complete'];
    }
}