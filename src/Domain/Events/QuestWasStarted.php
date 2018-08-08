<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Description;
use App\Domain\Quest\Difficulty;
use App\Domain\Quest\Reward;
use App\Domain\Quest\StartedAt;
use App\Domain\Quest\Title;
use Prooph\EventSourcing\AggregateChanged;

class QuestWasStarted extends AggregateChanged
{
    public function title(): Title
    {
        return $this->payload['title'];
    }

    public function description(): Description
    {
        return $this->payload['description'];
    }

    public function isComplete(): bool
    {
        return $this->payload['is_complete'];
    }

    public function difficulty(): Difficulty
    {
        return $this->payload['difficulty'];
    }

    /**
     * @return Reward[]
     */
    public function rewards(): array
    {
        return $this->payload['rewards'];
    }

    public function startedAt(): StartedAt
    {
        return $this->payload['started_at'];
    }
}