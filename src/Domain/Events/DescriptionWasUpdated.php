<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Description;
use Prooph\EventSourcing\AggregateChanged;

class DescriptionWasUpdated extends AggregateChanged
{
    public function updatedDescription(): Description
    {
        return $this->payload['updated_description'];
    }

    public function oldDescription(): Description
    {
        return $this->payload['old_description'];
    }
}