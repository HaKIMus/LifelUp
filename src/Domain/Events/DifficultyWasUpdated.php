<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Difficulty;
use Prooph\EventSourcing\AggregateChanged;

class DifficultyWasUpdated extends AggregateChanged
{
    public function updatedDifficulty(): Difficulty
    {
        return $this->payload['updated_difficulty'];
    }

    public function oldDifficulty(): Difficulty
    {
        return $this->payload['old_difficulty'];
    }
}