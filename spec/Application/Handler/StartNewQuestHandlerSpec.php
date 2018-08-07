<?php

namespace spec\App\Application\Handler;

use App\Application\Command\StartNewQuestCommand;
use App\Application\Handler\StartNewQuestHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StartNewQuestHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StartNewQuestHandler::class);
    }

    function it_handles_starting_a_new_quest(): void
    {
        $command = StartNewQuestCommand::withData(
            'Workout',
            'Do a workout',
            5,
            ['A cookie', 'Watching 1 Episode of SH', '15 min. break']);
    }
}
