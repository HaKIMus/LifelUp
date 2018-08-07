<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\StartNewQuestCommand;
use App\Domain\Quest;

class StartNewQuestHandler
{
    public function __construct()
    {

    }

    public function __invoke(StartNewQuestCommand $command): void
    {
        $quest = Quest::startNewQuest($command->title());
    }
}