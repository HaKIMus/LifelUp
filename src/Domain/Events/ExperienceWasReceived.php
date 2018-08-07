<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Experience;
use Prooph\EventSourcing\AggregateChanged;

class ExperienceWasReceived extends AggregateChanged
{
    public function receiveExperience(): Experience
    {
        return $this->payload['received_experience'];
    }
}