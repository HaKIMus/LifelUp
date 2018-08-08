<?php

declare(strict_types=1);

namespace App\Domain\Events;

use App\Domain\Quest\Title;
use Prooph\EventSourcing\AggregateChanged;

class TitleWasUpdated extends AggregateChanged
{
    public function updatedTitle(): Title
    {
        return $this->payload()['updated_title'];
    }

    public function oldTitle(): Title
    {
        return $this->payload()['old_title'];
    }
}