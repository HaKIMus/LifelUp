<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\StartNewQuestCommand;
use App\Domain\Quest;

class StartNewQuestHandler
{
    /*private $questCollection;

    public function __construct(EventStoreQuestCollection $questCollection)
    {
        $this->questCollection = $questCollection;
    }*/

    public function __invoke(StartNewQuestCommand $command): void
    {
        $quest = Quest::startNewQuest(
            $command->getTitle(),
            $command->getDescription(),
            $command->getDifficulty(),
            $command->getRewards()
        );

        $this->questCollection->save($quest);

        dump($this->questCollection->get($quest->id()));
    }
}