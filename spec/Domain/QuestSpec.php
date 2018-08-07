<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Exception\IncompleteQuestException;
use App\Domain\Exception\Quest\TryingToReceiveTwice;
use App\Domain\Quest;
use App\Domain\Quest\CompletedAt;
use App\Domain\Quest\Description;
use App\Domain\Quest\Experience;
use App\Domain\Quest\Reward;
use App\Domain\Quest\StartedAt;
use App\Domain\Quest\Title;
use PhpSpec\ObjectBehavior;

class QuestSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedThrough("startNewQuest", [
            new Title('Workout')
        ]);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Quest::class);
    }

    function it_may_be_completed(): void
    {
        $this->completeTheQuest();

        $this->isComplete()
            ->shouldReturn(true);

        $this->completedAt()
            ->shouldHaveType(CompletedAt::class);
    }

    function it_gives_experience(): void
    {
        $this->completeTheQuest();

        $this->receiveExperience();
    }

    function it_throws_exception_while_trying_to_receive_experience_twice(): void
    {
        $this->completeTheQuest();

        $this->receiveExperience();

        $this->shouldThrow(TryingToReceiveTwice::experience())
            ->during("receiveExperience");
    }

    function it_may_have_a_description(): void
    {
        $description = new Description("Do a workout!");

        $this->updateDescription($description);

        $this->description()
            ->shouldReturn($description);
    }

    function it_is_incomplete_by_default(): void
    {
        $this->isComplete()
            ->shouldReturn(false);
    }

    function it_may_have_an_reward(): void
    {
        $reward = new Reward('A cookie');

        $this->addReward($reward);

        $this->rewards()
            ->shouldHaveKey('A cookie');
    }

    function it_may_have_updated_title(): void
    {
        $this->updateTitle(new Title("Homework"));

    }

    function it_gives_a_reward_for_completing_it(): void
    {
        $reward = new Reward('A cookie');
        $this->addReward($reward);

        $this->completeTheQuest();

        $this->receiveRewards();

        $this->rewards()
            ->shouldHaveKey('none');

        $this->rewards()
            ->shouldHaveCount(1);
    }

    function it_has_information_when_the_quest_has_started(): void
    {
        $this->startedAt()
            ->shouldBeAnInstanceOf(StartedAt::class);
    }

    function it_has_information_when_the_quest_has_been_completed(): void
    {
        $this->completeTheQuest();

        $this->completedAt()
            ->shouldBeAnInstanceOf(CompletedAt::class);
    }

    function it_has_a_medium_difficulty_by_default(): void
    {
        $this->difficulty()->getDifficulty()
            ->shouldReturn('medium');
    }

    function it_throws_exception_while_receiving_a_reward_from_an_incomplete_quest(): void
    {
        $this->shouldThrow(IncompleteQuestException::class)
            ->during("receiveRewards");
    }
}
