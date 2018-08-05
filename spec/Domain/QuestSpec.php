<?php

declare(strict_types=1);

namespace spec\App\Domain;

use App\Domain\Quest;
use App\Domain\Exception\IncompleteQuestException;
use App\Domain\Quest\Experience;
use App\Domain\Quest\Title;
use App\Domain\Quest\Description;
use App\Domain\Quest\Reward;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(
            new Title("Workout") # Title
            # Description
            # No Reward by default
            # Default Medium difficulty
        );
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
    }

    function it_gives_experience(): void
    {
        $this->completeTheQuest();

        $experience = $this->receiveExperience()->getExperience()->shouldReturn(50);
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

        $this->rewards($reward)
            ->shouldReturn([$reward]);
    }

    function it_gives_a_reward_for_completing_it(): void
    {
        $reward = new Reward('A cookie');
        $this->addReward($reward);

        $this->completeTheQuest();

        $this->receiveRewards()
            ->shouldReturn([$reward]);
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
