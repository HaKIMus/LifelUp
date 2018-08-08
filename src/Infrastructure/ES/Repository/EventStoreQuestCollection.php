<?php

declare(strict_types=1);

namespace App\Infrastructure\ES\Repository;

use App\Domain\Quest;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\SnapshotStore\SnapshotStore;
use Ramsey\Uuid\Uuid;

class EventStoreQuestCollection extends AggregateRepository
{
    public function save(Quest $quest): void
    {
        $this->saveAggregateRoot($quest);
    }

    public function get(Uuid $questId): ?Quest
    {
        return $this->getAggregateRoot($questId->toString());
    }
}